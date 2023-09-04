document.addEventListener("DOMContentLoaded", function(event) {
  $('#select-tags').select2(
    init_select2('/api/tags', 'Select tags')
  );
  var simplemde = new SimpleMDE({ 
    element: document.getElementById("content")
  });
  function init_select2(url, placeholder) {
    return {
      placeholder: placeholder,
      ajax: {
        url: url,
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
    };
  };
});
