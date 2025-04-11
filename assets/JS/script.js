$(document).ready(function() {
    $('#languageSelect').change(function() {
       $('#selectedLanguage').val($(this).val());
       $('#languageForm').submit();
    });
});

const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

navToggle.addEventListener('click', () =>{
   navMenu.classList.add('show-menu')
})

navClose.addEventListener('click', () =>{
   navMenu.classList.remove('show-menu')
})

/*sidenav*/

function openNav() {
   document.getElementById("sidenav").style.width = "13rem";
 } 

function closeNav() {
   document.getElementById("sidenav").style.width = "0";
 }
 

const search = document.getElementById('search'),
      searchBtn = document.getElementById('search-btn'),
      searchClose = document.getElementById('search-close')

searchBtn.addEventListener('click', () =>{
   search.classList.add('show-search')
})

searchClose.addEventListener('click', () =>{
   search.classList.remove('show-search')
})

const login = document.getElementById('login'),
      loginBtn = document.getElementById('login-btn'),
      loginClose = document.getElementById('login-close')

loginBtn.addEventListener('click', () =>{
   login.classList.add('show-login')
})

loginClose.addEventListener('click', () =>{
   login.classList.remove('show-login')
})

/*password checking*/

document.getElementById('sign-up-form').addEventListener('submit', function(e) {
   var password = document.getElementById('password').value;
   var confirmPassword = document.getElementById('confirm-password').value;
   if (password !== confirmPassword) {
       e.preventDefault();
       document.getElementById('error-message').style.display = 'block';
       document.getElementById('confirm-password').style.borderColor = 'red';
   } else {
       document.getElementById('error-message').style.display = 'none';
       document.getElementById('confirm-password').style.borderColor = '';
   }
});

/*alert appearing*/

$(document).ready(function() {
   setTimeout(function() {
      $('.floating-alert').fadeOut();
   }, 3000);
});

/*pictures display*/

function scrollToTop() {
   window.scrollTo({
       top: 0,
       behavior: 'smooth'
   });
}

function filterSelection(category) {
   var items, i;
   items = document.getElementsByClassName("gallery-item");
   if (category === "all") category = "";
   for (i = 0; i < items.length; i++) {
       w3RemoveClass(items[i], "show");
       if (items[i].className.indexOf(category) > -1) w3AddClass(items[i], "show");
   }
}

function w3AddClass(element, name) {
   var i, arr1, arr2;
   arr1 = element.className.split(" ");
   arr2 = name.split(" ");
   for (i = 0; i < arr2.length; i++) {
       if (arr1.indexOf(arr2[i]) == -1) { element.className += " " + arr2[i]; }
   }
}

function w3RemoveClass(element, name) {
   var i, arr1, arr2;
   arr1 = element.className.split(" ");
   arr2 = name.split(" ");
   for (i = 0; i < arr2.length; i++) {
       while (arr1.indexOf(arr2[i]) > -1) {
           arr1.splice(arr1.indexOf(arr2[i]), 1);
       }
   }
   element.className = arr1.join(" ");
}

filterSelection("all");
function scrollToTop() {
   window.scrollTo({
       top: 0,
       behavior: 'smooth'
   });
}


document.getElementById('profile-img').addEventListener('click', function() {
   if (this.src.includes('Add+Profile+Image')) {
       document.getElementById('image_type').value = 'profile';
       var myModal = new bootstrap.Modal(document.getElementById('uploadModal'), {});
       myModal.show();
   }
});

document.getElementById('background-img').addEventListener('click', function() {
   if (this.src.includes('Add+Background+Image')) {
       document.getElementById('image_type').value = 'background';
       var myModal = new bootstrap.Modal(document.getElementById('uploadModal'), {});
       myModal.show();
   }
});

/*change background color in preview product page*/

$(".product-colors span").click(function() {
   $(".product-colors span").removeClass("active");
   $(this).addClass("active");
   $(".active").css("border-color", $(this).attr("data-color-sec"));
   $(".body").css("background", $(this).attr("data-color-primary"));
   $(".content h2").css("color", $(this).attr("data-color-sec"));
   $(".content h3").css("color", $(this).attr("data-color-sec"));
   $(".containe .imgBx").css("background", $(this).attr("data-color-sec"));
   $(".containe .details button").css("background", $(this).attr("data-color-sec"));
   $(".imgBx img").attr('src', $(this).attr("data-pic"));
});