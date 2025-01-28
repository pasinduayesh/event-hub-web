$(document).ready(function () {
  //drop down open and close
  $(".drop-down-icon").click(function () {
    var list = $(this).next(".drop-down-list");
    list.toggleClass("hide");
  });

  //drop down selection
  $(".drop-down-list li").click(function () {
    var selectedText = $(this).text();
    $(this).closest(".custom-drop-down").find("input").val(selectedText);
    $(this)
      .closest(".drop-down-container")
      .find(".drop-down-list")
      .addClass("hide");
  });

  //interets submittion
  const form1 = document.querySelectorAll(".personal-interets");
  form1.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();

      // Validate if all fields are filled
      var inputs = form.querySelectorAll('input[type="text"]');
      var isValid = true;

      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value.trim() === "") {
          isValid = false;
          break;
        }
      }

      if (!isValid) {
        showErrorMessage("Fill all the fields!");
        return;
      }

      console.log("Yess");
      const selectedCategories = Array.from(
        form.querySelectorAll(".interests-card-active")
      ).map(function (button) {
        return button.getAttribute("data-category-id");
      });

      form.querySelector(".selectedCategoriesInput").value =
        selectedCategories.join(",");

      form.submit();
    });
  });

  $(".add-events").on("submit", function (event) {
    event.preventDefault();
    var form = $(this);

    // Validate if all fields are filled
    var inputs = form.find('input[type="text"]');
    var isValid = true;

    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].value.trim() === "") {
        isValid = false;
        break;
      }
    }

    if (!isValid) {
      showErrorMessage("Fill all the fields!");
      return;
    }

    const selectedCategories = form.find(".interests-card-active").map(function () {
      return $(this).attr("data-category-id");
    }).get();

    if (selectedCategories.length === 0) {
      showErrorMessage("Please select a category!");
      return;
    }

    form.find(".selectedCategoriesInput").val(selectedCategories.join(","));
    showLoader()
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function (responseData) {
        console.log(responseData);
        if (responseData.success) {
          showLoader()
          showSuccessMessage(responseData.message);

          if (responseData.type == 'add') {
            form.trigger("reset");
            form.find("#previewImage").attr("src", "https://academy.edu.ly/default-images/program.jpg");
            form.find(".interests-card-active").removeClass("interests-card-active");
          }

        } else {
          showLoader()
          showErrorMessage("An error occurred: " + responseData.message);
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
        showLoader()
        showErrorMessage("An error occurred. Please try again later.");
      }
    });
  });

  $(".book-ticket").on("submit", function (event) {
    event.preventDefault();
    var form = $(this);
    showLoader()
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function (responseData) {
        console.log(responseData);
        if (responseData.success) {
          showLoader()
          showSuccessMessage(responseData.message);

        } else {
          showLoader()
          showErrorMessage("An error occurred: " + responseData.message);
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
        showLoader()
        showErrorMessage("An error occurred. Please try again later.");
      }
    });
  });

  $(".change-password").on("submit", function (event) {
    event.preventDefault();
    var form = $(this);

    // Validate if all fields are filled
    var inputs = form.find('input[type="password"]');
    var isValid = true;

    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].value.trim() === "") {
        isValid = false;
        break;
      }
    }

    if (!isValid) {
      showErrorMessage("Fill all the fields!");
      return;
    }
    showLoader()
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function (responseData) {
        console.log(responseData);
        if (responseData.success) {
          showLoader()
          showSuccessMessage(responseData.message);
          form.trigger("reset");
        } else {
          showLoader()
          showErrorMessage("An error occurred: " + responseData.message);
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
        showLoader()
        showErrorMessage("An error occurred. Please try again later.");
      }
    });
  });

  $(".delete-event-form").on("submit", function (event) {
    event.preventDefault();
    var form = $(this);
    showLoader()
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function (responseData) {
        console.log(responseData);
        if (responseData.success) {
          showLoader()
          showSuccessMessage(responseData.message);

        } else {
          showLoader()
          showErrorMessage("An error occurred: " + responseData.message);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr);
        showLoader()
        showErrorMessage("An error occurred. Please try again later.");
      }
    });
  });


  // update user
  // const form3 = document.querySelectorAll(".user-update");
  // form3.forEach(function (form) {
  //   form.addEventListener("submit", function (event) {
  //     event.preventDefault();

  //     // Validate if all fields are filled
  //     var inputs = form.querySelectorAll('input[type="text"]');
  //     var isValid = true;

  //     for (var i = 0; i < inputs.length; i++) {
  //       if (inputs[i].value.trim() === "") {
  //         isValid = false;
  //         break;
  //       }
  //     }

  //     if (!isValid) {
  //       showErrorMessage("Fill all the fields!");
  //       return;
  //     }

  //     console.log("Yess");
  //     const selectedCategories = Array.from(
  //       form.querySelectorAll(".interests-card-active")
  //     ).map(function (button) {
  //       return button.getAttribute("data-category-id");
  //     });

  //     if (selectedCategories.length === 0) {
  //       showErrorMessage("Please select a category!");
  //       return;
  //     }

  //     form.querySelector(".selectedCategoriesInput").value =
  //       selectedCategories.join(",");

  //     form.submit();
  //   });
  // });


  //

  //scroll div
  // Get all the card-slider divs and scroll buttons
  const cardSliders = document.querySelectorAll(".card-slider");
  const scrollLeftButtons = document.querySelectorAll(".scroll-left");
  const scrollRightButtons = document.querySelectorAll(".scroll-right");

  // Loop through each slider
  cardSliders.forEach((cardSlider, index) => {
    // Calculate the width of a single card
    const cardWidth = cardSlider.querySelector(".card").offsetWidth;

    // Add click event listeners to the scroll buttons
    scrollLeftButtons[index].addEventListener("click", () =>
      scrollLeft(cardSlider, cardWidth)
    );
    scrollRightButtons[index].addEventListener("click", () =>
      scrollRight(cardSlider, cardWidth)
    );
  });



  //

  const options = {
    margin: 0.2,
    filename: 'invoice.pdf',
    image: {
      type: 'jpeg',
      quality: 800
    },
    html2canvas: {
      scale: 4,
      // Set a larger viewport size to simulate desktop view
      viewport: { width: 1920, height: 1080 }
    },
    jsPDF: {
      unit: 'in',
      format: 'letter',
      orientation: 'portrait'
    }
  }

  $('.btn-download').click(function (e) {
    e.preventDefault();
    const element = document.getElementById('invoice');
    html2pdf().from(element).set(options).save();
  });


});

function showErrorMessage(message) {
  var popup = document.querySelector(".pop-up-msg");
  popup.classList.remove("success");
  popup.classList.remove("hide");
  popup.querySelector("span").textContent = message;
  // Scroll to top
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function showSuccessMessage(message) {
  var popup = document.querySelector(".pop-up-msg");
  popup.classList.add("success");
  popup.classList.remove("hide");
  popup.querySelector("span").textContent = message;
  // Scroll to top
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function showLoader() {
  var popup = document.querySelector(".pop-up-msg");
  popup.classList.add("hide");

  var popup = document.querySelector(".loader");

  popup.classList.toggle("hide");

  pointerEventsDisabled = !pointerEventsDisabled;
  toggleFormPointerEvents()
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });

}


var pointerEventsDisabled = false;

function toggleFormPointerEvents() {
  var forms = document.querySelectorAll("form");
  forms.forEach(function (form) {
    form.style.pointerEvents = pointerEventsDisabled ? "auto" : "none";
  });

  pointerEventsDisabled = !pointerEventsDisabled;
}


function scrollLeft(cardSlider, cardWidth) {
  cardSlider.scrollBy(-cardWidth, 0);
}

function scrollRight(cardSlider, cardWidth) {
  cardSlider.scrollBy(cardWidth, 0);
}

function toggleCategory(button) {
  button.classList.toggle("interests-card-active");
}

function previewImageTag(event) {
  var input = event.target;
  var image = document.getElementById("previewImage");

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      image.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function checkPasswordMatch() {
  var password = $("#password").val();
  var confirmPassword = $("#confirmpassword").val();

  if ((password === confirmPassword) && (password != '')) {
    $("#register-submit").removeClass('submit-btn-disabled');
  } else {
    $("#register-submit").addClass('submit-btn-disabled');
  }
}


function setPlaceholder(inputFieldId, outputSpanId, defaultValue) {
  var inputField = document.getElementById(inputFieldId);
  var outputSpan = document.getElementById(outputSpanId);
  outputSpan.innerText = inputField.value === '' ? defaultValue : inputField.value;
}