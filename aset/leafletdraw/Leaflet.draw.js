/**
 * Leaflet.draw assumes that you have already included the Leaflet library.
 */
L.drawVersion = '0.4.2';
/**
 * @class L.Draw
 * @aka Draw
 *
 *
 * To add the draw toolbar set the option drawControl: true in the map options.
 *
 * @example
 * ```js
 *      var map = L.map('map', {drawControl: true}).setView([51.505, -0.09], 13);
 *
 *      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
 *          attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
 *      }).addTo(map);
 * ```
 *
 * ### Adding the edit toolbar
 * To use the edit toolbar you must initialise the Leaflet.draw control and manually add it to the map.
 *
 * ```js
 *      var map = L.map('map').setView([51.505, -0.09], 13);
 *
 *      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
 *          attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
 *      }).addTo(map);
 *
 *      // FeatureGroup is to store editable layers
 *      var drawnItems = new L.FeatureGroup();
 *      map.addLayer(drawnItems);
 *
 *      var drawControl = new L.Control.Draw({
 *          edit: {
 *              featureGroup: drawnItems
 *          }
 *      });
 *      map.addControl(drawControl);
 * ```
 *
 * The key here is the featureGroup option. This tells the plugin which FeatureGroup contains the layers that
 * should be editable. The featureGroup can contain 0 or more features with geometry types Point, LineString, and Polygon.
 * Leaflet.draw does not work with multigeometry features such as MultiPoint, MultiLineString, MultiPolygon,
 * or GeometryCollection. If you need to add multigeometry features to the draw plugin, convert them to a
 * FeatureCollection of non-multigeometries (Points, LineStrings, or Polygons).
 */
L.Draw = {};

/**
 * @class L.drawLocal
 * @aka L.drawLocal
 *
 * The core toolbar class of the API — it is used to create the toolbar ui
 *
 * @example
 * ```js
 *      var modifiedDraw = L.drawLocal.extend({
 *          draw: {
 *              toolbar: {
 *                  buttons: {
 *                      polygon: 'Draw an awesome polygon'
 *                  }
 *              }
 *          }
 *      });
 * ```
 *
 * The default state for the control is the draw toolbar just below the zoom control.
 *  This will allow map users to draw vectors and markers.
 *  **Please note the edit toolbar is not enabled by default.**
 */
L.drawLocal = {
	draw: {
		toolbar: {
			// #TODO: this should be reorganized where actions are nested in actions
			// ex: actions.undo  or actions.cancel
			actions: {
				title: 'Batal menggambar',
				text: '<div style="padding-left: 10px; padding-right: 10px; height: 27px;">Batal</div>',
			},
			chosecolor: {
				title	: 'pilih warna',
				adefault: '<div style="background-color:#DA4D01; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				ablack	: '<div style="background-color:#000000; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				awhite	: '<div style="color:#000000; background-color:#ffffff; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				ared 	: '<div style="background-color:#ff0000; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				ayellow	: '<div style="color:#000000; background-color:#ffff00; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				ablue	: '<div style="background-color:#0066ff; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				apurple	: '<div style="background-color:#cc00cc; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				agray	: '<div style="background-color:#808080; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>',
				agreen	: '<div style="background-color:#029A10; padding-left: 10px; padding-right: 10px; height: 27px;">&nbsp;</div>'
			},
			finish: {
				title: 'Selesai gambar',
				text: '<div style="padding-left: 10px; padding-right: 10px; height: 27px;">Selesai</div>',
			},
			undo: {
				title: 'Hapus point terakhir',
				text: '<div style="padding-left: 10px; padding-right: 10px; height: 27px;">Hapus point terakhir</div>',
			},
			buttons: {
				polyline: 'Gambar polyline',
				polygon: 'Gambar polygon',
				rectangle: 'Gambar kotak',
				circle: 'Gambar lingkaran',
				marker: 'Taruh marker point',
				markerbulat: 'Taruh marker bulat',
				markerabu: 'Taruh marker abu',
				markermerah: 'Taruh marker merah',
				markerhijau: 'Taruh marker hijau',
				markerungu: 'Taruh marker ungu',
				markerbiru: 'Taruh marker biru'
			}
		},
		handlers: {
			circle: {
				tooltip: {
					start: 'Klik lalu drag untuk menggambar lingkaran'
				},
				radius: 'Radius'
			},
			marker: {
				tooltip: {
					start: 'Taruh marker point di map'
				}
			},
			markerbulat: {
				tooltip: {
					start: 'Taruh marker bulat di map'
				}
			},
			markerabu: {
				tooltip: {
					start: 'Taruh di map'
				}
			},
			markermerah: {
				tooltip: {
					start: 'Taruh di map'
				}
			},
			markerhijau: {
				tooltip: {
					start: 'Taruh di map'
				}
			},
			markerungu: {
				tooltip: {
					start: 'Taruh di map'
				}
			},
			markerbiru: {
				tooltip: {
					start: 'Taruh di map'
				}
			},
			polygon: {
				tooltip: {
					start: 'Klik untuk memulai menggambar bentuk.',
					cont: 'Klik lagi untuk melanjutkan',
					end: 'Klik point pertama untuk menutup'
				}
			},
			polyline: {
				error: '<strong>Error:</strong> bentuk tidak bisa menyilang!',
				tooltip: {
					// ini diganti ama jarak dan sudut skrg brp
					start: 'Klik untuk memulai menggambar garis',
					cont: 'Klik lagi untuk melanjutkan',
					end: 'Klik point terakhir untuk menutup'
					// ini diganti ama jarak dan sudut skrg brp
				}
			},
			rectangle: {
				tooltip: {
					start: 'Klik lalu drag untuk menggambar kotak'
				}
			},
			simpleshape: {
				tooltip: {
					end: 'Lepas mouse untuk selesai'
				}
			}
		}
	},
	edit: {
		toolbar: {
			actions: {
				save: {
					title: 'Simpan perubahan',
					text: '<div style="padding-left: 10px; padding-right: 10px; height: 27px;">Simpan</div>',
				},
				cancel: {
					title: 'Batal, batalkan semua perubahan',
					text: '<div style="padding-left: 10px; padding-right: 10px; height: 27px;">Batal</div>',
				}
			},
			buttons: {
				edit: 'Edit layers',
				editDisabled: 'Tidak ada layer untuk diedit',
				remove: 'Hapus layers',
				removeDisabled: 'Tidak ada layer untuk dihapus'
			}
		},
		handlers: {
			edit: {
				tooltip: {
					text: 'Drag point atau marker untuk edit',
					subtext: 'Klik batal untuk batalkan edit'
				}
			},
			remove: {
				tooltip: {
					text: 'Klik gambar yang ingin dihapus'
				}
			}
		}
	}
};
