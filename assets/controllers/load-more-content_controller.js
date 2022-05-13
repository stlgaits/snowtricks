import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['trick', 'tricks'];
    static values = {
        max: Number,
    }

    connect() {
        // this.tricksTarget.innerHTML = "Loading...";
        console.log(this.maxValue);
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }

    onLoadMore(event)
    {
        // console.log(this.maxValue);
        // console.log(event);
        console.log(this.tricksTarget);

    }

}
