/**
 * @class L.Draw.Marker
 * @aka Draw.Marker
 * @inherits L.Draw.Feature
 */
L.Draw.Marker = L.Draw.Feature.extend({
	statics: {
		TYPE: 'marker'
	},

	options: {
		icon: new L.icon({
	          iconUrl: 'aset/img/markerdefault.png',
	          iconSize: [25, 41],
	          iconAnchor: [12, 41],
	          popupAnchor: [1, -34],
	          shadowUrl : 'aset/img/marker-shadow.png',
	          shadowSize: [41,41]
	    }),
	    repeatMode: true,
		zIndexOffset: 2000 // This should be > than the highest z-index any markers
	},

	// @method initialize(): void
	initialize: function (map, options) {
		// Save the type so super can fire, need to do this as cannot do this.TYPE :(
		this.type = L.Draw.Marker.TYPE;

		L.Draw.Feature.prototype.initialize.call(this, map, options);
	},

	// GOPAL 2017 - chose color 
	// ngubah warna garis, via toolbar action. bukan draw control lg. biar g makan tempat
	chosecolorwhite: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerputih.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorblack: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerhitam.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecoloryellow: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerkuning.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolordefault: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerdefault.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorblue: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerbiru.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorgreen: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerhijau.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorpurple: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerungu.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorgray: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markerabu.png";
		this._marker.removeFrom(map).addTo(map);
	},
	chosecolorred: function () {
		this.options.__proto__.icon.options.iconUrl = "aset/img/markermerah.png";
		this._marker.removeFrom(map).addTo(map);
	},


	// @method addHooks(): void
	// Add listener hooks to this handler.
	addHooks: function () {
		L.Draw.Feature.prototype.addHooks.call(this);

		if (this._map) {
			this._tooltip.updateContent({ text: L.drawLocal.draw.handlers.marker.tooltip.start });

			// Same mouseMarker as in Draw.Polyline
			if (!this._mouseMarker) {
				this._mouseMarker = L.marker(this._map.getCenter(), {
					icon: L.divIcon({
						className: 'leaflet-mouse-marker',
						iconAnchor: [20, 20],
						iconSize: [40, 40]
					}),
					opacity: 0,
					zIndexOffset: this.options.zIndexOffset
				});
			}

			this._mouseMarker
				.on('click', this._onClick, this)
				.addTo(this._map);

			this._map.on('mousemove', this._onMouseMove, this);
			this._map.on('click', this._onTouch, this);
		}
	},

	// @method removeHooks(): void
	// Remove listener hooks from this handler.
	removeHooks: function () {
		L.Draw.Feature.prototype.removeHooks.call(this);

		if (this._map) {
			if (this._marker) {
				this._marker.off('click', this._onClick, this);
				this._map
					.off('click', this._onClick, this)
					.off('click', this._onTouch, this)
					.removeLayer(this._marker);
				delete this._marker;
			}

			this._mouseMarker.off('click', this._onClick, this);
			this._map.removeLayer(this._mouseMarker);
			delete this._mouseMarker;

			this._map.off('mousemove', this._onMouseMove, this);
		}
	},

	_onMouseMove: function (e) {
		var latlng = e.latlng;

		this._tooltip.updatePosition(latlng);
		this._mouseMarker.setLatLng(latlng);

		if (!this._marker) {
			this._marker = new L.Marker(latlng, {
				icon: this.options.icon,
				zIndexOffset: this.options.zIndexOffset
			});
			// Bind to both marker and map to make sure we get the click event.
			this._marker.on('click', this._onClick, this);
			this._map
				.on('click', this._onClick, this)
				.addLayer(this._marker);
		}
		else {
			latlng = this._mouseMarker.getLatLng();
			this._marker.setLatLng(latlng);
		}
	},

	_onClick: function () {
		this._fireCreatedEvent();

		this.disable();
		if (this.options.repeatMode) {
			this.enable();
		}
	},

	_onTouch: function (e) {
		// called on click & tap, only really does any thing on tap
		this._onMouseMove(e); // creates & places marker
		this._onClick(); // permanently places marker & ends interaction
	},

	_fireCreatedEvent: function () {
		var marker = new L.Marker.Touch(this._marker.getLatLng(), { icon: this.options.icon });
		L.Draw.Feature.prototype._fireCreatedEvent.call(this, marker);
	}
});
