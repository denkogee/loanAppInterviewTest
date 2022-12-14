<?php

if (!function_exists('_lang')) {
	function _lang($string = '') {

		// $target_lang = get_language();
		$target_lang = 'English';

		if ($target_lang == '') {
			$target_lang = "language";
		}

		if (file_exists(resource_path() . "/language/$target_lang.php")) {
			include resource_path() . "/language/$target_lang.php";
		} else {
			include resource_path() . "/language/language.php";
		}

		if (array_key_exists($string, $language)) {
			return $language[$string];
		} else {
			return $string;
		}
	}
}

if (!function_exists('get_favicon')) {
	function get_favicon() {
		$favicon = get_option("favicon");
		if ($favicon == "") {
			return asset("public/backend/images/favicon.png");
		}
		return asset("public/uploads/media/$favicon");
	}
}

if (!function_exists('get_option')) {
	function get_option($name, $optional = '') {
		$value = Cache::get($name);

		if ($value == "") {
			$setting = DB::table('settings')->where('name', $name)->get();
			if (!$setting->isEmpty()) {
				$value = $setting[0]->value;
				Cache::put($name, $value);
			} else {
				$value = $optional;
			}
		}
		return $value;

	}
}

if (!function_exists('get_logo')) {
	function get_logo() {
		$logo = get_option("logo");
		if ($logo == "") {
			return asset("public/backend/images/company-logo.png");
		}
		return asset("public/uploads/media/$logo");
	}
}

//Request Count
if (!function_exists('request_count')) {
	function request_count($request, $html = false, $class = "sidebar-notification-count") {
		if ($request == 'pending_loans') {
			$notification_count = \App\Models\Loan::where('status', 0)->count();
		}

		if ($html == false) {
			return $notification_count;
		}

		if ($notification_count > 0) {
			return '<span class="' . $class . '">' . $notification_count . '</span>';
		}

	}
}

if (!function_exists('create_option')) {
	function create_option($table, $value, $display, $selected = '', $where = NULL) {
		$options = '';
		$condition = '';
		if ($where != NULL) {
			$condition .= "WHERE ";
			foreach ($where as $key => $v) {
				$condition .= $key . "'" . $v . "' ";
			}
		}

		if (is_array($display)) {
			$display_array = $display;
			$display = $display_array[0];
			$display1 = $display_array[1];
		}

		$query = DB::select("SELECT * FROM $table $condition");
		foreach ($query as $d) {
			if ($selected != '' && $selected == $d->$value) {
				if (!isset($display_array)) {
					$options .= "<option value='" . $d->$value . "' selected='true'>" . ucwords($d->$display) . "</option>";
				} else {
					$options .= "<option value='" . $d->$value . "' selected='true'>" . ucwords($d->$display . ' - ' . $d->$display1) . "</option>";
				}
			} else {
				if (!isset($display_array)) {
					$options .= "<option value='" . $d->$value . "'>" . ucwords($d->$display) . "</option>";
				} else {
					$options .= "<option value='" . $d->$value . "'>" . ucwords($d->$display . ' - ' . $d->$display1) . "</option>";
				}
			}
		}

		echo $options;
	}
}
