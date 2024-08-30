(function( $ ) {
  /**
   * widgetContent dynamic post- and widget-id
   */
  $(document).ready( function() {
    $(document).on('change', '.elementor-control-dynamic-tags-post-id-select select', function(e) {
      let $target = $(e.currentTarget),
        $parent = $target.closest('.dialog-message'),
        $input = $parent.find('.elementor-control-post-id input');

      $input.val($target.val());
      $input.trigger('input');

      loadWidgetData($target.val(), $parent);
    })


    $(document).on('change', '.elementor-control-dynamic-tags-widget-id-select select', function(e) {
      let $target = $(e.currentTarget),
        $parent = $target.closest('.dialog-message'),
        $input = $parent.find('.elementor-control-widget-id input');

      if ($target.val() === '' || !$target.val()) {
        return;
      }

      $input.val($target.val());
      $input.trigger('input');
    });

    jQuery(document).on('click', '.elementor-control-dynamic-tags-widget-id-select select', function(e) {
      console.log('click widget select')
      let $target = $(e.currentTarget),
        $parent = $target.closest('.dialog-message'),
        $input = $parent.find('.elementor-control-post-id input')

      if (!$target.find('option').length) {
        loadWidgetData($input.val(), $parent)
      }
    })

  });

  function loadWidgetData(postid, $parent) {
    jQuery.get(ajaxurl, {
      action: 'dynamic_tags_get_elementor_data',
      postid: postid,
    }, function(data) {
      let $widgetSelect = $parent.find('.elementor-control-dynamic-tags-widget-id-select select');

      $widgetSelect.find('option').remove()
      $widgetSelect.append('<option />')

      for (let index in data) {
        $widgetSelect.append('<option value="' + index + '">' + data[index] + '</option>')
      }
    }, 'json')

  }
})(jQuery);