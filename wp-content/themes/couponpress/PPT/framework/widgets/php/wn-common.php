<?php

class wf_wn_common extends wf_wn {
  // helper function for creating select's options
  function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    foreach ($options as $tmp) {
      if ($selected == $tmp['val']) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      }
    }

    if($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options

  // helper function for $_POST checkbox handling
  function check_var_isset(&$values, $variables) {
    foreach ($variables as $key => $value) {
      if (!isset($values[$key])) {
        $values[$key] = $value;
      }
    }
  } // check_var_isset

  // helper function for displaying LI elements
  function create_list($list_id, $options, $class, $widget_id, $output = true) {
    $out = "\n";

    if (is_array($options)) {
      foreach ($options as $sub_array) {
        if (is_array($sub_array) && trim($sub_array['label'])) {
          $out .= '<li wnfn="' . $sub_array['wnfn'] . '" id="wn_' . $widget_id . '_' . $sub_array['label'] . '" class="' . $class . '">' . $sub_array['label'] . "\n";
          if (isset($sub_array['dialog'])) {
            $out .= '<a href="#" class="promptID" id="' . $sub_array['dialog'] . '"><img title="Options" alt="Options" src="' . PPT_PATH . 'framework/widgets/images/attach.gif" /></a>';
          }
          $out .= '<a wn-help="' . $sub_array['label'] . '" href="#" class="help" title="Click to show help"><img alt="Click to show help" title="Click to show help" src="' . PPT_PATH . 'framework/widgets/images/help.png" /></a>';
          $out .= '</li>';
        }
      }
    }

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_list
} // class wf_wn_common
?>