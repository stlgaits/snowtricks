import { Controller } from '@hotwired/stimulus';
import { useDispatch } from 'stimulus-use';


/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        offset: Number,
    }
    connect() {
        console.log(this.offsetValue);
        useDispatch(this, { debug: true });
    }

    load(event) {
        console.log(event);
        this.dispatch('load', { offset: this.offsetValue });
    }

}