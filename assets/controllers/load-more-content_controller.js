import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['trick', 'tricks'];
    static values = {
        max: Number,
        infoUrl: String,
        offset: 0,
        page: 1
    }

    connect()
    {
        this.trickTargets.forEach((element) => {
            this.offsetValue++;
        });
    }

    onLoadMore(event)
    {
        this.loadAnimation(event);
        try {
            if(this.offsetValue >= this.maxValue) {
                this.pageValue++;
                axios.get(this.infoUrlValue, {  
                    params: { 
                        page: this.pageValue,
                        offset : this.offsetValue
                    } 
                    })
                .then((response) => {
                    this.tricksTarget.innerHTML += response.data;
                });
            }
        } catch(e) {
            console.log(e.responseText)
        }
    }

    async loadAnimation(event) {
        try {
            const buttonText = event.currentTarget.innerText;
            const button = event.currentTarget;
            button.innerText = '...';
            await setTimeout(function(){
                button.innerText = buttonText;
            }, 500)
        } catch(e) {
            console.log(e.responseText)
        }
    }

}
