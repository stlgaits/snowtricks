import { Controller } from '@hotwired/stimulus';
import axios from 'axios';


/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['trick', 'tricks'];
    static values = {
        max: Number,
        infoUrl: String,
        offset: 0,
        page: 1,
    }

    // TODO: set a condition which says that if we've reached the maximum number
    // of tricks, THEN DO NOT DISPLAY THE SAME FRAME TWICE !!!!!
    // TODO: 2 => hide the 'add trick' buttons (when logged in) from the frame

    connect() {
        this.trickTargets.forEach((element) => {
            this.offsetValue++;
        });
    }

    async onLoadMore(event) {
        await this.loadAnimation(event)
            .then(() => {
                this.removeLoadingButton(event);
            });
        try {
            if (this.offsetValue >= this.maxValue) {
                this.pageValue++;
                axios.get(this.infoUrlValue, {
                    params: {
                        page: this.pageValue,
                        offset: this.offsetValue
                    }
                })
                    .then((response) => {
                        this.tricksTarget.innerHTML += response.data;
                        this.removeFrameTitle();
                        this.appendLoadingButton(event);
                        this.removeAddTrickButton();
                    });
            }
        } catch (e) {
            console.log(e.responseText);
        }
    }

    async loadAnimation(event) {
        try {
            const buttonText = event.currentTarget.innerText;
            const button = event.currentTarget;
            button.innerText = '...';
            await setTimeout(function () {
                button.innerText = buttonText;
            }, 1000);
        } catch (e) {
            console.log(e.responseText);
        }
    }

    async removeLoadingButton(event) {
        const button = event.currentTarget;
        await button.remove();
    }

    appendLoadingButton(event) {
        const button = event.currentTarget;
        if (button !== null) {
            this.tricksTarget.innerHTML += button.innerHTML;
        }
    }

    removeFrameTitle() {
        const frameTitles = document.getElementsByTagName('h2');
        const frameTitlesToRemove = [];
        for (let i = 0; i < frameTitles.length; i++) {
            if (i > 0) {
                frameTitlesToRemove[i] = frameTitles[i];
            }
        }
        frameTitlesToRemove.forEach((h2Element) => {
            h2Element.remove();
        });
    }

    removeAddTrickButton() {
        const addTrickButtons = document.querySelectorAll('.add-trick');
        const addTrickButtonsToRemove = [];
        for (let i = 0; i < addTrickButtons.length; i++) {
            if (i > 0) {
                addTrickButtonsToRemove[i] = addTrickButtons[i];
            }
        }
        addTrickButtonsToRemove.forEach((btn) => {
            btn.remove();
        });
    }

}
