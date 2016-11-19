/*  written by:   Rui Zhu    
	assisted by:   Yue Gu
	base on the online open soruce
	website: http://www.html5tricks.com/	
*/


/*
(function () {

var HSD = {

*/
    function toggleSnippet(button, snippet) {

      
        if (Element.visible(snippet)) {
            Element.update(button, '(show)');
        } else {
            Element.update(button, '(hide)');
        }
        
        Element.toggle(snippet);
    }
prettyPrint();
/*
}

window.HSD = HSD;

})();
*/
