console.log('This would be the main JS file.');
 function requestValidCategoriesLoop() {
     if (query()!=latestServerQuery) {
       vars = {
         queryType: "getValidCategories",
         queryText: escape(query())
       }
       ajaxCaller.get("categories.php", vars, onValidCategoriesResponse,
                      false, null);
       latestServerQuery = query();
     }
     setTimeout('requestValidCategoriesLoop();', THROTTLE_PERIOD);
 }