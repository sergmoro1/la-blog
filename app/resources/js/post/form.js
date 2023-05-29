document.addEventListener("DOMContentLoaded", function(event) {
  $('#select-tags').select2({
    placeholder: "<?= __('Select tags') ?>",
    ajax: {
      url: '/api/tags',
      type: 'get',
      data: function (params) {
        var query = {
          search: params.term,
          type: 'public'
        }
        return query;
      },
      processResults: function (response) {
        const data = response.data;
        let results = data.map(function (item) {
          return {
            id: item.id,
            text: item.name
          };
        });
        return {results: results};
      }
    }
  });
  var simplemde = new SimpleMDE({ element: document.getElementById("content") });
});
