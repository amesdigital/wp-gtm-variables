function word_count() {
  $string = get_post_field('post_content', $post->ID);

  if (empty($string)) {
    return 0;
  }

  $string = trim(strip_tags($string));

  if (empty($string)) {
    return 0;
  }

  $patterns = array(
    'strip' => '/<[a-zA-Z\/][^<>]*>/',
    'clean' => '/[0-9.(),;:!?%#$¿\'"_+=\\/-]+/',
    'w'     => '/\S\s+/',
    'c'     => '/\S/',
  );

  $string = preg_replace($patterns['strip'], ' ', $string);
  $string = preg_replace('/&nbsp;|&#160;/i', ' ', $string);
  $string = preg_replace($patterns['clean'], '', $string);

  if (!strlen(preg_replace('/\s/', '', $string))) {
    return 0;
  }

  return preg_match_all($patterns['w'], $string, $matches) + 1;
}

function word_range()
{
  $word_count = word_count();

  if ($word_count < 300) {
    $word_range = '0-300';
  } elseif ($word_count < 500) {
    $word_range = '300-500';
  } elseif ($word_count < 750) {
    $word_range = '500-750';
  } elseif ($word_count < 1000) {
    $word_range = '750-1000';
  } elseif ($word_count < 1500) {
    $word_range = '1000-1500';
  } elseif ($word_count < 2000) {
    $word_range = '1500-2000';
  } elseif ($word_count < 2500) {
    $word_range = '2000-2500';
  } elseif ($word_count < 3000) {
    $word_range = '2500-3000';
  } elseif ($word_count < 3500) {
    $word_range = '3000-3500';
  } elseif ($word_count < 4000) {
    $word_range = '3500-4000';
  } elseif ($word_count < 4500) {
    $word_range = '4000-4500';
  } elseif ($word_count < 5000) {
    $word_range = '4500-5000';
  } elseif ($word_count >= 5000) {
    $word_range = '5000+';
  }
  return $word_range;
}

function tag_manager_variables() {
	$url = 'http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	echo "
	<script>
	  dataLayer = [{
	    'wordCount': '". word_count() ."',
	    'wordRange': '". word_range() ."'
	  }];
	</script>
	";
}
add_action ( 'wp_head', 'tag_manager_variables' );
