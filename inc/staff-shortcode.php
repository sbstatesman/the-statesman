<?php


function staff_shortcode_handler($atts, $content = null) {
  /* 
  Three types allowed:
   normal - Shows name, description and photo
   short - shows only name
   assistant - shows only name and photo
  */
  extract( shortcode_atts( array(
    'group' => '1', // registered
    'type' => 'normal',
  ), $atts ) );
  
  /* Requires Groups plugin */
  
  $Groups_group = new Groups_Group($group);

  $out = '';

  foreach ($Groups_group->users as $Group_user) {
    $user = $Group_user->user;
    
    $out .= '<div class="hmedia hmedia-list staffmember staffmember-' . $type . '">';

    if ($type != "short") {
      $out .= '<figure class="thumbnail">' . get_avatar($user->ID, 128) . '</figure>';
    }

      $out .= '<div class="block">';
      $out .= '<a href="' . get_author_posts_url($user->ID) . '">';
      $out .= '<h4>' . $user->display_name. '</h4>';
      $out .= '</a>';
      
      if ($type != "short") {
        $out .= '<span class="metatext">' . $Groups_group->name . '</span>';
      }

      if ($type == "normal") {
        $out .= '<p>' . get_user_meta($user->ID, 'description', true) . '</p>';
      }
      $out .= '</div>';
    $out .= '</div>';
  }

  return $out . $content;
}

add_shortcode('staff', 'staff_shortcode_handler');

?>