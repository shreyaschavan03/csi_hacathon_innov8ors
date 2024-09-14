const std = document.getElementById("Student")
const carr = document.getElementById("Mentor1")
const ment = document.getElementById("Mentor2")
const selectElement = document.querySelector('select');
const enterButton = document.querySelector('#submit');

enterButton.addEventListener('click', (e) => {
  e.preventDefault();
  
  const selectedValue = selectElement.value;

  switch (selectedValue) {
    case 'std':
      window.location.href = 'student.html';
      break;
    case 'carr':
      window.location.href = 'mentor1.html'; // redirect to mentor1.html
      break;
    case 'ment':
      window.location.href = 'mentor2.html'; // redirect to mentor2.html
      break;
    default:
      console.log('Invalid selection');
  }
});