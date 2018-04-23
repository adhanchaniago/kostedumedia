/*  Global class for simulating the movement of particle through a 1km wind grid

    credit: All the credit for this work goes to: https://github.com/cambecc for creating the repo:
      https://github.com/cambecc/earth. The majority of this code is directly take nfrom there, since its awesome.

    This class takes a canvas element and an array of data (1km GFS from http://www.emc.ncep.noaa.gov/index.php?branch=GFS)
    and then uses a mercator (forward/reverse) projection to correctly map wind vectors in "map space".

    The "start" method takes the bounds of the map at its current extent and starts the whole gridding,
    interpolation and animation process.
*/

var Waves = function( params ){
  var VELOCITY_SCALE = 0.0004;             // scale for wind velocity (completely arbitrary--this value looks nice)
  // var VELOCITY_SCALE = 0.0009;             // scale for wind velocity (completely arbitrary--this value looks nice)
  var INTENSITY_SCALE_STEP = 40;            // step size of particle intensity color scale
  var MAX_WIND_INTENSITY = 200;              // wind velocity at which particle intensity is maximum (m/s)
  var MAX_PARTICLE_AGE = 20;                // max number of frames a particle is drawn before regeneration
  var PARTICLE_LINE_WIDTH = 5;              // line width of a drawn particle
  var PARTICLE_MULTIPLIER = 1/1000;              // particle count scalar (completely arbitrary--this values looks nice)
  var PARTICLE_REDUCTION = 1.00;            // reduce particle count to this much of normal for mobile devices
  var FRAME_RATE = 30;                      // desired milliseconds per frame
  var BOUNDARY = 0.45;

  var NULL_WIND_VECTOR = [NaN, NaN, null];  // singleton for no wind in the form: [u, v, magnitude]
  var TRANSPARENT_BLACK = [255, 0, 0, 0];

  var τ = 2 * Math.PI;
  var H = Math.pow(10, -5.2);

  // interpolation for vectors like wind (u,v,m)
  var bilinearInterpolateVector = function(x, y, g00, g10, g01, g11) {
      var rx = (1 - x);
      var ry = (1 - y);
      var a = rx * ry,  b = x * ry,  c = rx * y,  d = x * y;
      var u = g00[0] * a + g10[0] * b + g01[0] * c + g11[0] * d;
      var v = g00[1] * a + g10[1] * b + g01[1] * c + g11[1] * d;
      return [u, v, Math.sqrt(u * u + v * v)];
  };


  var createWindBuilder = function(dComp, hComp) {
      var dData = dComp.data, hData = hComp.data;
      console.log("panjang D"+dComp.data.length);
      console.log("panjang H"+hComp.data.length);
      
      
      // var uDataX, uDataY = [];

      // for(var i=0; i<dComp.length; i++){
        // var uDataX[i] = hData[i] * Math.cos(dData[i]/180 * Math.PI);
        // var vDataY[i] = hData[i] * Math.sin(dData[i]/180 * Math.PI);
      // }

      // console.log(dData.length);  
      // console.log(Math.sin(30/180 * Math.PI ));  
      // console.log(Math.sin(60/180 * Math.PI ));  
      // console.log(Math.sin(90/180 * Math.PI )); 
      // console.log(Math.sin(0/180 * Math.PI ));  
      // for (var i=0; i<dData.length; i++){
        // console.log(Math.cos(dData[i]));  
      // }
      

      // var uDataX = hData * Math.cos(dData);
      // var vDataY = hData * Math.sin(dData);
      // var uDataX, uDataY = [] ;
      
      return {
          header: dComp.header,          
          data: function(i) {
              // return [dData[i], hData[i]];

              // if (dData[i] || hData[i] != 0){
                // uDataX[i] = hData[i] * Math.cos(dData[i]/180 * Math.PI);
                // vDataY[i] = hData[i] * Math.sin(dData[i]/180 * Math.PI);
              // } else {
                // uDataX[i] = 0;
                // vDataY[i] = 0;                
              // }

              // ngubah dari tinggi dan derajat jd x (U) dan y (V). sekalian ngubah juga format derajat angin jadi derajat true north (cartesius) (gopalgopel2015)
              return [hData[i] * 40 * Math.cos((270-dData[i])/180 * Math.PI), hData[i] * 40 * Math.sin((270-dData[i])/180 * Math.PI)];

              // return [uDataX[i], vDataY[i]];
          },
          interpolate: bilinearInterpolateVector
      }
  };

  var createBuilder = function(data) {
      var dComp = null, hComp = null, scalar = null;

      data.forEach(function(record) {

        // klo pake data waves dari windity API
        //gopalgopel 2015
          switch (record.header.parameterNumberName) {
              case "Significant_height_of_combined_wind_waves_and_swell": hComp = record; break; //height waves
              // case "PERPW": uComp = record; break; //primary wave mean period
              case "Primary_wave_direction": dComp = record; break; //primary waves direction              
              // case "UGRD": dComp = record; break;
              // case "VGRD": hComp = record; break;
              default:
                scalar = record;
          }
        //gopalgopel 2015
      });

      return createWindBuilder(dComp, hComp);
  };

  var buildGrid = function(data, callback) {
      var builder = createBuilder(data);
      // console.log(builder);
      var header = builder.header;
      var λ0 = header.lo1, φ0 = header.la1;  // the grid's origin (e.g., 0.0E, 90.0N)
      var Δλ = header.dx, Δφ = header.dy;    // distance between grid points (e.g., 2.5 deg lon, 2.5 deg lat)
      var ni = header.nx, nj = header.ny;    // number of grid points W-E and N-S (e.g., 144 x 73)
      var date = new Date(header.refTime);
      // date.setHours(date.getHours() + header.forecastTime);
      date.setHours(date.getHours() + 0); //hardcode by gopalgopel2015. melihat dari header.forecastTime yang nilainya selalu = 3

      // Scan mode 0 assumed. Longitude increases from λ0, and latitude decreases from φ0.
      // http://www.nco.ncep.noaa.gov/pmb/docs/grib2/grib2_table3-4.shtml
      var grid = [], p = 0;
      var isContinuous = Math.floor(ni * Δλ) >= 360;
      for (var j = 0; j < nj; j++) {
          var row = [];
          for (var i = 0; i < ni; i++, p++) {
              row[i] = builder.data(p);
          }
          if (isContinuous) {
              // For wrapped grids, duplicate first column as last column to simplify interpolation logic
              row.push(row[0]);
          }
          grid[j] = row;
      }

      function interpolate(λ, φ) {
          var i = floorMod(λ - λ0, 360) / Δλ;  // calculate longitude index in wrapped range [0, 360)
          var j = (φ0 - φ) / Δφ;                 // calculate latitude index in direction +90 to -90

          var fi = Math.floor(i), ci = fi + 1;
          var fj = Math.floor(j), cj = fj + 1;

          var row;
          if ((row = grid[fj])) {
              var g00 = row[fi];
              var g10 = row[ci];
              if (isValue(g00) && isValue(g10) && (row = grid[cj])) {
                  var g01 = row[fi];
                  var g11 = row[ci];
                  if (isValue(g01) && isValue(g11)) {
                      // All four points found, so interpolate the value.
                      return builder.interpolate(i - fi, j - fj, g00, g10, g01, g11);
                  }
              }
          }
          return null;
      }
      callback( {
          date: date,
          interpolate: interpolate
      });
  };



  /**
   * @returns {Boolean} true if the specified value is not null and not undefined.
   */
  var isValue = function(x) {
      return x !== null && x !== undefined;
  }

  /**
   * @returns {Number} returns remainder of floored division, i.e., floor(a / n). Useful for consistent modulo
   *          of negative numbers. See http://en.wikipedia.org/wiki/Modulo_operation.
   */
  var floorMod = function(a, n) {
      return a - n * Math.floor(a / n);
  }

  /**
   * @returns {Number} the value x clamped to the range [low, high].
   */
  var clamp = function(x, range) {
      return Math.max(range[0], Math.min(x, range[1]));
  }

  /**
   * @returns {Boolean} true if agent is probably a mobile device. Don't really care if this is accurate.
   */
  var isMobile = function() {
      return (/android|blackberry|iemobile|ipad|iphone|ipod|opera mini|webos/i).test(navigator.userAgent);
  }

  /**
   * Calculate distortion of the wind vector caused by the shape of the projection at point (x, y). The wind
   * vector is modified in place and returned by this function.
   */
  var distort = function(projection, λ, φ, x, y, scale, wind, waves) {
      var u = wind[0] * scale;
      var v = wind[1] * scale;
      var d = distortion(projection, λ, φ, x, y, waves);

      // Scale distortion vectors by u and v, then add.
      wind[0] = d[0] * u + d[2] * v;
      wind[1] = d[1] * u + d[3] * v;
      return wind;
  };

  var distortion = function(projection, λ, φ, x, y, waves) {
      var τ = 2 * Math.PI;
      var H = Math.pow(10, -5.2);
      var hλ = λ < 0 ? H : -H;
      var hφ = φ < 0 ? H : -H;

      var pλ = project(φ, λ + hλ,waves);
      var pφ = project(φ + hφ, λ, waves);

      // Meridian scale factor (see Snyder, equation 4-3), where R = 1. This handles issue where length of 1º λ
      // changes depending on φ. Without this, there is a pinching effect at the poles.
      var k = Math.cos(φ / 360 * τ);
      return [
          (pλ[0] - x) / hλ / k,
          (pλ[1] - y) / hλ / k,
          (pφ[0] - x) / hφ,
          (pφ[1] - y) / hφ
      ];
  };



  var createField = function(columns, bounds, callback) {

      /**
       * @returns {Array} wind vector [u, v, magnitude] at the point (x, y), or [NaN, NaN, null] if wind
       *          is undefined at that point.
       */
      function field(x, y) {
          var column = columns[Math.round(x)];
          return column && column[Math.round(y)] || NULL_WIND_VECTOR;
      }

      // Frees the massive "columns" array for GC. Without this, the array is leaked (in Chrome) each time a new
      // field is interpolated because the field closure's context is leaked, for reasons that defy explanation.
      field.release = function() {
          columns = [];
      };

      field.randomize = function(o) {  // UNDONE: this method is terrible
          var x, y;
          var safetyNet = 0;
          do {
              x = Math.round(Math.floor(Math.random() * bounds.width) + bounds.x);
              y = Math.round(Math.floor(Math.random() * bounds.height) + bounds.y)
          } while (field(x, y)[2] === null && safetyNet++ < 30);
          o.x = x;
          o.y = y;
          return o;
      };

      //field.overlay = mask.imageData;
      //return field;
      callback( bounds, field );
  };

  var buildBounds = function( bounds, width, height ) {
      var upperLeft = bounds[0];
      var lowerRight = bounds[1];
      var x = Math.round(upperLeft[0]); //Math.max(Math.floor(upperLeft[0], 0), 0);
      var y = Math.max(Math.floor(upperLeft[1], 0), 0);
      var xMax = Math.min(Math.ceil(lowerRight[0], width), width - 1);
      var yMax = Math.min(Math.ceil(lowerRight[1], height), height - 1);
      return {x: x, y: y, xMax: width, yMax: yMax, width: width, height: height};
  };

  var deg2rad = function( deg ){
    return (deg / 180) * Math.PI;
  };

  var rad2deg = function( ang ){
    return ang / (Math.PI/180.0);
  };

  var invert = function(x, y, waves){
    var mapLonDelta = waves.east - waves.west;
    var worldMapRadius = waves.width / rad2deg(mapLonDelta) * 360/(2 * Math.PI);
    var mapOffsetY = ( worldMapRadius / 2 * Math.log( (1 + Math.sin(waves.south) ) / (1 - Math.sin(waves.south))  ));
    var equatorY = waves.height + mapOffsetY;
    var a = (equatorY-y)/worldMapRadius;

    var lat = 180/Math.PI * (2 * Math.atan(Math.exp(a)) - Math.PI/2);
    var lon = rad2deg(waves.west) + x / waves.width * rad2deg(mapLonDelta);
    return [lon, lat];
  };

  var mercY = function( lat ) {
    return Math.log( Math.tan( lat / 2 + Math.PI / 4 ) );
  };


  var project = function( lat, lon, waves) { // both in radians, use deg2rad if neccessary
    var ymin = mercY(waves.south);
    var ymax = mercY(waves.north);
    var xFactor = waves.width / ( waves.east - waves.west );
    var yFactor = waves.height / ( ymax - ymin );

    var y = mercY( deg2rad(lat) );
    var x = (deg2rad(lon) - waves.west) * xFactor;
    var y = (ymax - y) * yFactor; // y points south
    return [x, y];
  };


  var interpolateField = function( grid, bounds, extent, callback ) {

    var projection = {};
    var velocityScale = VELOCITY_SCALE;

    var columns = [];
    var x = bounds.x;

    function interpolateColumn(x) {
        var column = [];
        for (var y = bounds.y; y <= bounds.yMax; y += 2) {
                var coord = invert( x, y, extent );
                if (coord) {
                    var λ = coord[0], φ = coord[1];
                    if (isFinite(λ)) {
                        var wind = grid.interpolate(λ, φ);
                        if (wind) {
                            // velocity diassign disini
                            wind = distort(projection, λ, φ, x, y, velocityScale, wind, extent);
                            column[y+1] = column[y] = wind;

                        }
                    }
                }
        }
        columns[x+1] = columns[x] = column;
    }

    (function batchInterpolate() {
                var start = Date.now();
                while (x < bounds.width) {
                    interpolateColumn(x);
                    x += 2;
                    if ((Date.now() - start) > 1000) { //MAX_TASK_TIME) {
                        setTimeout(batchInterpolate, 25);
                        return;
                    }
                }
          createField(columns, bounds, callback);
    })();
  };


  var animate = function(bounds, field) {

    function asColorStyle(r, g, b, a) {
        return "rgba(" + 243 + ", " + 243 + ", " + 238 + ", " + a + ")";
    }

    function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
    function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
    function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
    function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}

    function windIntensityColorScale(step, maxWind) {

        result = [
           // blue to red
          // "rgba(" + hexToR('#178be7') + ", " + hexToG('#178be7') + ", " + hexToB('#178be7') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#8888bd') + ", " + hexToG('#8888bd') + ", " + hexToB('#8888bd') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#b28499') + ", " + hexToG('#b28499') + ", " + hexToB('#b28499') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#cc7e78') + ", " + hexToG('#cc7e78') + ", " + hexToB('#cc7e78') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#de765b') + ", " + hexToG('#de765b') + ", " + hexToB('#de765b') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#ec6c42') + ", " + hexToG('#ec6c42') + ", " + hexToB('#ec6c42') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#f55f2c') + ", " + hexToG('#f55f2c') + ", " + hexToB('#f55f2c') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#fb4f17') + ", " + hexToG('#fb4f17') + ", " + hexToB('#fb4f17') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#fe3705') + ", " + hexToG('#fe3705') + ", " + hexToB('#fe3705') + ", " + 0.5 + ")",
          // "rgba(" + hexToR('#ff0000') + ", " + hexToG('#ff0000') + ", " + hexToB('#ff0000') + ", " + 0.5 + ")"
          

          /* original aneh
          "rgba(" + hexToR('#00ffff') + ", " + hexToG('#00ffff') + ", " + hexToB('#00ffff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#64f0ff') + ", " + hexToG('#64f0ff') + ", " + hexToB('#64f0ff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#87e1ff') + ", " + hexToG('#87e1ff') + ", " + hexToB('#87e1ff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#a0d0ff') + ", " + hexToG('#a0d0ff') + ", " + hexToB('#a0d0ff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#b5c0ff') + ", " + hexToG('#b5c0ff') + ", " + hexToB('#b5c0ff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#c6adff') + ", " + hexToG('#c6adff') + ", " + hexToB('#c6adff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#d49bff') + ", " + hexToG('#d49bff') + ", " + hexToB('#d49bff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#e185ff') + ", " + hexToG('#e185ff') + ", " + hexToB('#e185ff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#ec6dff') + ", " + hexToG('#ec6dff') + ", " + hexToB('#ec6dff') + ", " + 0.5 + ")",
          "rgba(" + hexToR('#ff1edb') + ", " + hexToG('#ff1edb') + ", " + hexToB('#ff1edb') + ", " + 0.5 + ")"
          */

          //gopalgopel 2015
          // ijo -> kuning -> merah        
          // "rgba(" + hexToR('#000080') + ", " + hexToG('#000080') + ", " + hexToB('#000080') + ", " + 0.8 + ")", //navy          
          // "rgba(" + hexToR('#008000') + ", " + hexToG('#008000') + ", " + hexToB('#008000') + ", " + 0.8 + ")", //green
          // "rgba(" + hexToR('#00ff00') + ", " + hexToG('#00ff00') + ", " + hexToB('#00ff00') + ", " + 0.8 + ")", //lime
          // "rgba(" + hexToR('#adff2f') + ", " + hexToG('#adff2f') + ", " + hexToB('#adff2f') + ", " + 0.8 + ")", //greenyellow
          // "rgba(" + hexToR('#ffd700') + ", " + hexToG('#ffd700') + ", " + hexToB('#ffd700') + ", " + 0.8 + ")", //gold
          // "rgba(" + hexToR('#daa520') + ", " + hexToG('#daa520') + ", " + hexToB('#daa520') + ", " + 0.8 + ")", //golden rod
          // "rgba(" + hexToR('#ff6347') + ", " + hexToG('#ff6347') + ", " + hexToB('#ff6347') + ", " + 0.8 + ")", //tomatoes
          // "rgba(" + hexToR('#ff4500') + ", " + hexToG('#ff4500') + ", " + hexToB('#ff4500') + ", " + 0.8 + ")", //orangered         
          // "rgba(" + hexToR('#ff0000') + ", " + hexToG('#ff0000') + ", " + hexToB('#ff0000') + ", " + 0.8 + ")", //red
          // "rgba(" + hexToR('#8b0000') + ", " + hexToG('#8b0000') + ", " + hexToB('#8b0000') + ", " + 0.8 + ")"  //darkred

          //gopalgopel 2015
          // ijo -> kuning -> merah versi gelap biar keliatan
          "rgba(" + hexToR('#000080') + ", " + hexToG('#000080') + ", " + hexToB('#000080') + ", " + 0.4 + ")", //navy                            
          "rgba(" + hexToR('#006400') + ", " + hexToG('#006400') + ", " + hexToB('#006400') + ", " + 0.5 + ")", //darkgreen        
          "rgba(" + hexToR('#669933') + ", " + hexToG('#669933') + ", " + hexToB('#669933') + ", " + 0.7 + ")", //669933
          "rgba(" + hexToR('#999900') + ", " + hexToG('#999900') + ", " + hexToB('#999900') + ", " + 0.6 + ")", //999900          
          "rgba(" + hexToR('#cc9900') + ", " + hexToG('#cc9900') + ", " + hexToB('#cc9900') + ", " + 0.8 + ")", //cc9900
          "rgba(" + hexToR('#cc6600') + ", " + hexToG('#cc6600') + ", " + hexToB('#cc6600') + ", " + 0.8 + ")", //cc6600
          "rgba(" + hexToR('#ff4500') + ", " + hexToG('#ff4500') + ", " + hexToB('#ff4500') + ", " + 0.8 + ")", //orangered         
          "rgba(" + hexToR('#ff0000') + ", " + hexToG('#ff0000') + ", " + hexToB('#ff0000') + ", " + 0.8 + ")", //red
          "rgba(" + hexToR('#8b0000') + ", " + hexToG('#8b0000') + ", " + hexToB('#8b0000') + ", " + 0.9 + ")",  //darkred
          "rgba(" + hexToR('#8b0015') + ", " + hexToG('#8b0015') + ", " + hexToB('#8b0015') + ", " + 0.9 + ")"  //8b0015

          //gopalgopel 2015
          /* semua putih.. ini kalau ada layer lagi u/ warna wind, pressure, temperature, dll (ky windity.com)
          "rgba(" + hexToR('#f0f8ff') + ", " + hexToG('#f0f8ff') + ", " + hexToB('#f0f8ff') + ", " + 0.8 + ")", //alice white
          "rgba(" + hexToR('#f0f8ff') + ", " + hexToG('#f0f8ff') + ", " + hexToB('#f0f8ff') + ", " + 0.8 + ")", //alice white
          "rgba(" + hexToR('#f0f8ff') + ", " + hexToG('#f0f8ff') + ", " + hexToB('#f0f8ff') + ", " + 0.8 + ")" //alice white
          */
        ]
        /*
        var result = [];
        for (var j = 225; j >= 100; j = j - step) {
          result.push(asColorStyle(j, j, j, 1));
        }
        */
        result.indexFor = function(m) {  // map wind speed to a style
            return Math.floor(Math.min(m, maxWind) / maxWind * (result.length - 1));
        };
        return result;
    }

    var colorStyles = windIntensityColorScale(INTENSITY_SCALE_STEP, MAX_WIND_INTENSITY);
    var buckets = colorStyles.map(function() { return []; });

    var particleCount = Math.round(bounds.width * bounds.height * PARTICLE_MULTIPLIER);
    if (isMobile()) {
      particleCount *= PARTICLE_REDUCTION;
    }

    var fadeFillStyle = "rgba(0, 0, 0, 0.97)";

    //gopalgopel2015
    // var wavesFillStyle = ["rgba(100,100,100,0.1)", "rgba(150,150,150,0.15)", "rgba(200,200,200,0.2)", "rgba(255,255,255,0.3)"] : ["rgba(200,200,200,1)", "rgba(215,215,215,1)", "rgba(235,235,235,1)", "rgba(255,255,255,1)"];

    var particles = [];
    for (var i = 0; i < particleCount; i++) {
        particles.push(field.randomize({age: Math.floor(Math.random() * MAX_PARTICLE_AGE) + 0}));
        // console.log(field.randomize({age: Math.floor(Math.random() * MAX_PARTICLE_AGE) + 0}));
    }

    function evolve() {
        buckets.forEach(function(bucket) { bucket.length = 0; });
        particles.forEach(function(particle) {
            if (particle.age > MAX_PARTICLE_AGE) {
                field.randomize(particle).age = 0;
            }
            var x = particle.x;
            var y = particle.y;
            var v = field(x, y);  // vector at current position
            var m = v[2];
            if (m === null) {
                particle.age = MAX_PARTICLE_AGE;  // particle has escaped the grid, never to return...
            }
            else {
                var xt = x + v[0];
                var yt = y + v[1];
                if (field(xt, yt)[2] !== null) {
                    // Path from (x,y) to (xt,yt) is visible, so add this particle to the appropriate draw bucket.
                    particle.xt = xt;
                    particle.yt = yt;
                    buckets[colorStyles.indexFor(m)].push(particle);
                }
                 else {
                    // Particle isn't visible, but it still moves through the field.
                    particle.x = xt;
                    particle.y = yt;
                }
            }
            particle.age += 1;
        });
    }
    // console.log(particles);

    var g = params.canvas.getContext("2d");
    g.lineWidth = PARTICLE_LINE_WIDTH;
    g.fillStyle = fadeFillStyle;

    function draw() {
        // Fade existing particle trails.
        var prev = g.globalCompositeOperation;
        g.globalCompositeOperation = "destination-in";
        g.fillRect(bounds.x, bounds.y, bounds.width, bounds.height);
        g.globalCompositeOperation = prev;

        // Draw new particle trails.
        buckets.forEach(function(bucket, i) {
            if (bucket.length > 0) {
                g.beginPath();
                g.strokeStyle = colorStyles[i];
                bucket.forEach(function(particle) {
                    g.moveTo(particle.x, particle.y);
                    g.lineTo(particle.xt, particle.yt);
                    particle.x = particle.xt;
                    particle.y = particle.yt;
                });
                g.stroke();
            }
        });
    }

    (function frame() {
        try {
            waves.timer = setTimeout(function() {
              requestAnimationFrame(frame);
              evolve();
              draw();
            }, 1000 / FRAME_RATE);
        }
        catch (e) {
            console.error(e);
        }
    })();
  }

  var start = function( bounds, width, height, extent ){

    var mapBounds = {
      south: deg2rad(extent[0][1]),
      north: deg2rad(extent[1][1]),
      east: deg2rad(extent[1][0]),
      west: deg2rad(extent[0][0]),
      width: width,
      height: height
    };

    stop();

    // build grid
    buildGrid( params.data, function(grid){
      // interpolateField
      interpolateField( grid, buildBounds( bounds, width, height), mapBounds, function( bounds, field ){
        // animate the canvas with random points
        waves.field = field;
        animate( bounds, field );
      });

    });
  };

  var stop = function(){
    if (waves.field) waves.field.release();
    if (waves.timer) clearTimeout(waves.timer)
  };


  var waves = {
    params: params,
    start: start,
    stop: stop
  };

  return waves;
}



// shim layer with setTimeout fallback
window.requestAnimationFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          window.oRequestAnimationFrame ||
          window.msRequestAnimationFrame ||
          function( callback ){
            window.setTimeout(callback, 1000 / 20);
          };
})();

