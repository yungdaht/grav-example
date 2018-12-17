---
title: Custom Form Example
template: form
form:
    name: contact-form
    fields:
        - name: name
          label: Name
          placeholder: Enter your name
          autofocus: on
          autocomplete: on
          type: text
          validate:
            required: true

        - name: email
          label: Email
          placeholder: Enter your email address
          type: email
          validate:
            required: true

        - name: g-recaptcha-response
          label: Captcha
          type: captcha
          recaptcha_site_key: 6LfOjIIUAAAAAOukg7wkVePof7uFSsInO66w4eVI
          recaptcha_not_validated: 'Captcha not valid!'
          validate:
            required: true

    buttons:
        - type: submit
          value: Submit

    process:
        - captcha:
            recaptcha_secret: 6LfOjIIUAAAAAC0MWB2rqcr7sPPNsUIO9QW5K3vP
        - custom-form-thanks: true
---