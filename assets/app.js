/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import 'bootstrap-icons/font/bootstrap-icons.css';
import './styles/app.scss';
const $ = require('jquery');

require('bootstrap');
// start the Stimulus application
import './bootstrap';
import './swipe';

const favorite = document.getElementById('watchlist');

favorite.addEventListener('click', (e) => {
        e.preventDefault();
        let linkIcon = e.currentTarget
        let link = linkIcon.href;
        fetch(link)
        // Extract the JSON from the response
            .then(res => res.json())
        // Then update the icon
            .then((res) => {
                let watchlistIcon = linkIcon.firstElementChild;
                if (res.isInWatchList) {
                    watchlistIcon.classList.remove('bi-heart');
                    watchlistIcon.classList.add('bi-heart-fill');
                } else {
                    watchlistIcon.classList.remove('bi-heart-fill');
                    watchlistIcon.classList.add('bi-heart');
                }
            });
    }
)





