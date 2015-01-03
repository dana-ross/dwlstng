<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

/**
 * Class SelectOptionsRenderer
 * Functor to render <select> tag options with one option as a selected value
 */
class SelectOptionsRenderer {

	protected $selected_value;

	/**
	 * @param string $selected_value The value currently selected
	 */
	function __construct($selected_value = null) {
		$this->selected_value = $selected_value;
	}

	/**
	 * @param array $options Associative array of select options
	 *
	 * @return string HTML
	 * @uses selected renders selected="selected" attribute if values match
	 */
	public function __invoke(array $options) {

		$html = '';
		return (array_walk(
			$options,
			function($label, $value) use (&$html) {
				$html .= '<option value="' . esc_attr( $value ) . '" ' . selected( $this->selected_value, $value, false ) . '>' . esc_html( $label ) . '</option>';
			}
		)) ? $html : '';

	}

}
