

  class Validator {
  constructor(data) {
    this.data = data;
    this.errors = {};
  }

   required(value, message) {
    if (!value || value.trim() === '') {
      return message;
    }
    return null;
  }

  minLength(value, length, message) {
    if (value.length < length) {
      return message;
    }
    return null;
  }

  email(value, message) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
      return message;
    }
    return null;
  }

  yturl(value, message) {
    const yturlregex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    if (!yturlregex.test(value)) {
      return message;
    }
    return null;
  }

  maxLength(value, length, message) {
    if (value.length > length) {
      return message;
    }
    return null;
  }

  phone(value, message) {
    // Simple phone validation: 10 digits
    const phoneRegex = /^[6-9][0-9]{9}$/;
    if (!phoneRegex.test(value)) {
      return message;
    }
    return null;
  }

  pan(value, message) {
    // PAN format: ABCDE1234F
    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    if (!panRegex.test(value)) {
      return message;
    }
    return null;
  }

  aadhar(value, message) {
    // Aadhar format: 12 digits
    const aadharRegex = /^[2-9]{1}[0-9]{11}$/;
    if (!aadharRegex.test(value)) {
      return message;
    }
    return null;
  }

  password(value, message) {
    // Password must be at least 8 characters long and include at least one digit
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordRegex.test(value)) {
      return message;
    }
    return null;
  }

  url(value, message) {
    // Simple URL format validation
    const urlRegex = /^(https?:\/\/)[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(\/\S*)?$/;
    if (!urlRegex.test(value)) {
      return message;
    }
    return null;
  }

  domain(value, message) {
    // Simple domain format validation
    const domainRegex = /^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!domainRegex.test(value)) {
      return message;
    }
    return null;
  }

  eventID(value, message) {
    // Event ID format: E followed by 4 digits
    const eventIDRegex = /^[a-zA-Z0-9_.-]+$/;
    if (!eventIDRegex.test(value)) {
      return message;
    }
    return null;
  }

  custom(validateFn, message) {
    if (!validateFn()) {
      return message;
    }
    return null;
  }


  // New method for real-time validation on input change or blur
  validateField(field, value) {
    this.errors[field] = null; // Reset error for the field

    const fieldData = this.data[field];
    const { rules } = fieldData;

    for (const rule of rules) {
      const { type, message, minLength, validate } = rule;

      switch (type) {
        case 'required':
          this.errors[field] = this.required(value, message);
          break;
        case 'minLength':
          this.errors[field] = this.minLength(value, minLength, message);
          break;
        case 'maxLength':
          this.errors[field] = this.maxLength(value, maxLength, message);
          break;
        case 'phone':
          this.errors[field] = this.phone(value, message);
          break;
        case 'pan':
          this.errors[field] = this.pan(value, message);
          break;
        case 'aadhar':
          this.errors[field] = this.aadhar(value, message);
          break;
        case 'password':
          this.errors[field] = this.password(value, message);
          break;
        case 'url':
          this.errors[field] = this.url(value, message);
          break;
        case 'yturl':
          this.errors[field] = this.yturl(value, message);
          break;
        case 'domain':
          this.errors[field] = this.domain(value, message);
          break;
        case 'eventID':
          this.errors[field] = this.eventID(value, message);
          break;
        case 'email':
          this.errors[field] = this.email(value, message);
          break;
        case 'custom':
          this.errors[field] = this.custom(validate, message);
          break;       
        // Add cases for other validation types as needed

      }

      if (this.errors[field]) {
        break;
      }
    }

    // Display or hide error message dynamically (assuming you have a function to update the UI)
    this.updateErrorMessage(field, this.errors[field]);

    return this.errors[field];
  }

  // New method to update UI with error messages
  updateErrorMessage(field, error) {
    let currentField=document.getElementById(field);
    
    if(this.errors[field]){
      document.getElementById(`${field}Msg`).innerText = error;
      document.getElementById(field).focus();
        
      currentField.classList.remove("is-valid");
      currentField.classList.add("is-invalid"); 
    }
    else{
      document.getElementById(`${field}Msg`).innerText = "";
      currentField.classList.remove("is-invalid");
      currentField.classList.add("is-valid");
     
    }
    
  }

  // Modified validate method to perform real-time validation for all fields
  validate() {
    for (const field in this.data) {
      if (this.data.hasOwnProperty(field)) {
        const fieldData = this.data[field];
        const { value } = fieldData;

        // Validate the field in real-time
        this.validateField(field, value);
      }
    }

    // Check for errors
    const hasErrors = Object.values(this.errors).some((error) => error !== null);

    return {
      error: hasErrors,
      errorMsgs: this.errors,
    };
  }
}

// Example usage with real-time validation

// Assuming you have a form with input elements and error message elements
const formElements = document.querySelectorAll('input[type=text], textarea, select, input[type=time]');

// Create a map to store the initial values of each field
const initialFieldValues = new Map();

// Initialize the map with the current values of form elements
formElements.forEach((element) => {
  initialFieldValues.set(element.id, element.value);
});

// Dynamically generate 'fields' object based on form elements
const fields = {};

formElements.forEach((element) => {

  if(element.type=="submit"){
    return;
  }

  fields[element.id] = {
    value: element.value,
    rules: [],
  };

  // Example: add required rule if the element has the 'required' attribute
  if (element.hasAttribute('required')) {
    fields[element.id].rules.push({
      type: 'required',
      message: `${element.id} is required`,
    });
  }

  if (element.hasAttribute('domain')) {
    fields[element.id].rules.push({
        type: 'domain',
        message: 'Domain is invalid',
      });
  }

  if (element.hasAttribute('email')) {
    fields[element.id].rules.push({
        type: 'email',
        message: 'Email is invalid',
      });
  }

  if (element.hasAttribute('phone')) {
    fields[element.id].rules.push({
        type: 'phone',
        message: 'Phone no. is invalid',
      });
  }


  if (element.hasAttribute('url')) {
    fields[element.id].rules.push({
        type: 'url',
        message: 'URL is invalid',
      });
  }

  if (element.hasAttribute('yturl')) {
    fields[element.id].rules.push({
        type: 'yturl',
        message: 'URL is invalid',
      });
  }

  if (element.hasAttribute('minLength')) {
    fields[element.id].rules.push({
        type: 'minLength',
        message: `Name can't be less than ${element.minLength} characters`,
        minLength: element.minLength,
      });
  }

 if (element.hasAttribute('maxLength')) {
    fields[element.id].rules.push({
        type: 'maxLength',
        message: `Name can't be more than ${element.maxLength} characters`,
        maxLength: element.maxLength,
      });
  }


  // Add more rules or conditions based on your requirements

  // Initialize the element's value as the initial value
  fields[element.id].initialValue = element.value;
});

// Initialize the validator
var validator = new Validator(fields);

// Attach event listeners for input change or blur events
formElements.forEach((element) => {
  element.addEventListener('input', () => {
    
    const fieldName = element.id;
    const fieldValue = element.value;
    
    fields[fieldName].value = fieldValue;

    // Perform real-time validation on input change
    validator.validateField(fieldName, fieldValue);

  });

  element.addEventListener('blur', () => {
    const fieldName = element.id;
    const fieldValue = element.value;

    fields[fieldName].value = fieldValue;

    validator.validateField(fieldName, fieldValue);
  
  });
});

const submitBtn=document.querySelector("#submit-btn");
const form=document.querySelector("#form");

submitBtn.addEventListener("click", function() {

    formElements.forEach((element) => {
      element.blur();
    });

    let result=validator.validate();
    console.log(result);
    if(!result.error){
      form.submit();
    }
});



















