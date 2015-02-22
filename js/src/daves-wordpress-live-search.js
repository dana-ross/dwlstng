document.addEventListener('DOMContentLoaded', function () {

	var active_requests = [],
		compiled_templates = {
			'search-results': _.template(DavesWordPressLiveSearch.templates['search-results'])
		},
		search_boxes = document.querySelectorAll('input[name=s]');

	/**
	 * Check if a given element has a given class
	 *
	 * @param elem
	 * @param classname
	 * @returns {boolean}
	 */
	function has_class(elem, classname) {
		return ((' ' + elem.className + ' ').replace(/[\t\r\n\f]/g, ' ').indexOf(classname) > -1);
	}

	/**
	 * Get the height of the WordPress admin bar, if present
	 *
	 * @returns {int}
	 */
	function admin_bar_height() {

		var admin_bar = document.getElementById('wpadminbar');

		if (admin_bar) {
			return admin_bar.getBoundingClientRect().height;
		}
		else {
			return 0;
		}

	}

	/**
	 * Cancel any active AJAX requests
	 */
	function cancel_active_requests() {

		var loop_guard = 0;

		while (0 < active_requests.length) {

			loop_guard += 1;
			if (200 < loop_guard) {
				return;
			}

			active_requests.pop().abort();

		}

	}

	/**
	 * Parse search results HTML and append to the document's body
	 * @param {string} markup
	 * @returns {Element}
	 */
	function show_results(markup) {

		var results_wrapper = document.createElement('DIV'), results_element, response_data = JSON.parse(markup).data;
		results_wrapper.innerHTML = compiled_templates['search-results'](
			{
				'results': response_data.post_data,
				'more': response_data.more,
				'search_link': response_data.search_link
			}
		);
		results_element = results_wrapper.getElementsByTagName('UL')[0];
		document.body.appendChild(results_element);
		return results_element;

	}

	/**
	 * Get an element's offset relative to the entire page
	 *
	 * @param elem
	 * @returns {{top: (Number|number), left: (Number|number)}}
	 */
	function page_relative_offset(elem) {

		var left_offset = elem.offsetLeft,
			top_offset = elem.offsetTop,
			parent = elem.offsetParent,
			loop_guard = 0;

		while (parent && parent != document.body) {
			loop_guard += 1;
			if (200 < loop_guard) {
				break;
			}

			left_offset += parent.offsetLeft;
			top_offset += parent.offsetTop;
			parent = parent.offsetParent;

		}

		return {
			top : top_offset,
			left: left_offset
		};

	}

	function do_search(e) {

		cancel_active_requests();
		hide_search();

		if ('' !== e.target.value) {

			var target_url = DavesWordPressLiveSearch.endpoint + '/' + encodeURIComponent(e.target.value);

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {

						var results_element = show_results(xmlhttp.responseText);

						var search_box_dimensions = e.target.getBoundingClientRect(),
							search_box_position = page_relative_offset(e.target);

						var results_position = {
							left: search_box_position.left + parseInt(DavesWordPressLiveSearch.settings.offsets.x, 10),
							top : search_box_position.top + parseInt(DavesWordPressLiveSearch.settings.offsets.y, 10) + admin_bar_height()
						};

						results_element.style.position = 'absolute';
						results_element.style.left = results_position.left + 'px';
						results_element.style.display = 'block';

						var top_offset = 0;
						switch (DavesWordPressLiveSearch.settings.results_direction) {
							case 'up':
								top_offset = (-1 * results_element.getBoundingClientRect().height);
								break;
							case 'down':
							default:
								top_offset = search_box_dimensions.height;
								break;
						}

						results_element.style.top = (results_position.top + top_offset) + 'px';

					}
					else {
						console.log('something else other than 200 was returned');
					}
				}
			}

			xmlhttp.open('GET', target_url, true);
			xmlhttp.send();

			active_requests.push(xmlhttp);

		}

	}

	/**
	 * Remove search results from the DOM, if they are present
	 */
	function hide_search() {

		if (document.getElementById('dwls-results')) {
			document.body.removeChild(document.getElementById('dwls-results'));
		}

	}

	// Register handlers
	document.addEventListener('click', function (e) {
		for (var search_boxes_index in search_boxes) {
			if (search_boxes.hasOwnProperty(search_boxes_index)) {

				if (!(search_boxes[search_boxes_index].nodeName)) {
					continue;
				}

				if (e.target === search_boxes[search_boxes_index]) {
					return;
				}

				if (search_boxes[search_boxes_index].contains(e.target)) {
					return;
				}

			}
		}
		if ('dwls-results' === e.target.id) {
			return;
		}

		if (document.getElementById('dwls-results') && document.getElementById('dwls-results').contains(e.target)) {
			return;
		}

		hide_search();

	});

	for (var search_boxes_index in search_boxes) {
		if (search_boxes.hasOwnProperty(search_boxes_index)) {

			if ('object' !== typeof(search_boxes[search_boxes_index])) {
				continue;
			}

			if (has_class(search_boxes[search_boxes_index], 'adminbar-input')) {
				continue;
			}

			search_boxes[search_boxes_index].autocomplete = 'off';
			search_boxes[search_boxes_index].addEventListener('keyup', do_search);
		}

	}


});