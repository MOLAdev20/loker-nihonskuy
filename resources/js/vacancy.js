import 'choices.js/public/assets/styles/choices.min.css';
import Choices from 'choices.js';

  // Pass single element
  const element = document.querySelector('#job-placement');

  // Passing options (with default options)
  new Choices(element, {
    allowHTML: true,
    searchEnabled: true,
    itemSelectText: ''
  });