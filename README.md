# Faq

testing for custom plugin

## Requirements

This plugin requires Craft CMS 5.2.0 or later, and PHP 8.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Faq”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require faq-manage/craft-faq

# tell Craft to install the plugin
./craft plugin/install faq
```
# display the faqs from entries 

        {% if entry.[handler] is not empty %}
        <div>
            <ul>
                {% for faqId in entry.[handler] %}
                {% set faqData = craft.faq.getFaqById(faqId) %}
                    <li>
                        <strong>{{ faqData.question }}</strong><br>
                        {{ faqData.answer }}
                    </li>
                {% endfor %}
            </ul>
        </div>
        {% endif %}
