# Drupal 8 Multilingual
This is a sample Drupal 8 Multilingual Project.
Project is using standard Drupal site setup.

# Setting up on local
- Clone this repository.
- composer install
- lando start

# Setting up site
- Once you are done with local setup, you can visit http://drupal-8-multilingual.lndo.site/core/install.php
- Select "Install from existing configuration", which will install the configuration and other things based on Umami profile.
- Once we are done with the setup, we can uninstall and install demo_umami_content module to create the content.

# Solr Search
- Solr search is out of box provided by the search_api_solr module.
- Configuration related to solr are kept on "solr-config-templates" directory.

# Custom code
- umami_multilingual module contains code and related artifacts that are discussed in the session.
- It contains configuration form, content entity translation, configuration translation and other things that developers can implement using multilingual API
