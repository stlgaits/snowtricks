
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['field'];
    count = 0;
    //TODO: try to adapt this jQuery sample code (from SF Docs) to implement
    // the ability to add videos (and then images & groups) directly from the
    // add new trick view
    add()
    {
        this.count++;
        this.fieldTarget.innerText = this.count;
    }
    // add-collection-widget.js
// jQuery(document).ready(function () {
//     jQuery('.add-another-collection-widget').click(function (e) {
//         var list = jQuery(jQuery(this).attr('data-list-selector'));
//         // Try to find the counter of the list or use the length of the list
//         var counter = list.data('widget-counter') || list.children().length;

//         // grab the prototype template
//         var newWidget = list.attr('data-prototype');
//         // replace the "__name__" used in the id and name of the prototype
//         // with a number that's unique to your emails
//         // end name attribute looks like name="contact[emails][2]"
//         newWidget = newWidget.replace(/__name__/g, counter);
//         // Increase the counter
//         counter++;
//         // And store it, the length cannot be used if deleting widgets is allowed
//         list.data('widget-counter', counter);

//         // create a new list element and add it to the list
//         var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
//         newElem.appendTo(list);
//     });
// });
}



