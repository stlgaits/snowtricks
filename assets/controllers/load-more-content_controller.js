import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['trick', 'tricks'];
    static values = {
        max: Number,
        infoUrl: String
    }

    connect() {
        console.log(this.infoUrlValue)
        // console.log(this.trickTargets);
        // this.tricksTarget.innerHTML = "Loading...";
        // console.log(this.maxValue);
        this.trickTargets.forEach((element) => {
            console.log(element);
        });
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }

    onLoadMore(event)
    {
        console.log(event);
        // GET request for remote image in node.js
        // axios({
        //     method: 'get',
        //     url: 'http://bit.ly/2mTM3nY',
        //     responseType: 'stream'
        // })
        //     .then(function (response) {
        //     response.data.pipe(fs.createWriteStream('ada_lovelace.jpg'))
        //     });
        try {
            axios.get(this.infoUrlValue)
            .then((response) => {
                console.log(response)
                // const audio = new Audio(response.data.url);
                // audio.play();
            });
        } catch (e) {
            console.log(e.responseText)
        }
        // console.log(this.maxValue);
        // console.log(this.tricksTarget);
        // console.log(event.currentTarget);
        // this.trickTargets.forEach((element) => {
        //     console.log(element);
        // });

        // this.tricksTarget.appendChild(moreTricks);
    }

}
