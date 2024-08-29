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


      jQuery.get(ajaxurl, {
        action: 'dynamic_tags_get_elementor_data',
        postid: $target.val()
      }, function(data) {
        let $widgetSelect = $parent.find('.elementor-control-dynamic-tags-widget-id-select select'),
          $widgetInput = $parent.find('.elementor-control-widget-id input')

        $widgetSelect.find('option').remove();
        $widgetSelect.append('<option />');

        for (let index in data) {
          $widgetSelect.append('<option value="' + index +'">' + data[index] + '</option>');
        }
      }, 'json');
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

  });
})(jQuery);