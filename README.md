# OpenEMR module - Demo Farm add-ons  [![Build Status](https://travis-ci.org/zerai/oe-module-demo-farm-add-ons.svg?branch=master)](https://travis-ci.org/zerai/oe-module-demo-farm-add-ons)

**This module tries to follow the [official guidelines](https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf) for "custom module" development and tries to clarify aspects not yet defined, such as best practices, versioning, compatibility between modules, folder structure, etc. etc.**

**Before version v1.0.0, you should consider this repository as highly EXPERIMENTAL.  Backward Compatibility can be broken frequently.**

This module provides specifically designed capabilities for a demo installation of [OpenEMR](https://github.com/openemr/openemr). Don't install this module in a real environment.

Features for Maintainers|Comunity  - (OpenSource modules)
- [ ] (**WIP**) Show and search available openEMR modules on packagist.org
- [ ] Add additional information (official/unofficial module) business logic (store, mark, filter) to the list.

Features for Vendors|Developers - (Private|Closed modules)
- [ ] Show and search available openEMR modules form a custom source 
- [ ] Add additional information (free/paid support type..) business logic (store, mark, filter, chain) to the list.


## Installation

    To prevent deleting an installed module when doing upgrades, install with:

    composer require zerai/oe-module-demo-farm-add-ons
