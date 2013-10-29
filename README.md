deims-sevilleta-custom
======================

To be used in sites/default/modules with a site built with https://github.com/lter/deims

Extensions to the DEIMS built in D6 migration -- accomodate customizations made at
Sevilleta LTER DEIMS D6

Download the code issuing at the prompt:

git clone --branch 7.x-1.x git@github.com:isangil/deims-sevilleta-custom my-custom-sev-module

where my-custom-sev-module is the folder that will contain the code.

You want to copy the contents of the folder to the custom module location
under sites/default/modules.  Here, we are naming this module "Sevilleta",
to be consistent, you may want to create a folder named sevilleta

mkdir sites/default/modules/
mkdir sites/default/modules/sevilleta

then copy the contents over

cp -fr ~/my-custom-sev-module sites/default/modules/sevilleta

Once in there, you will see the "sevilleta" module in the list of modules of
your DEIMS install. You may enable it (or use drush to enable it).

Your new vocabularies, content types, and modifications will be available
to you, as well as new extended migration classes.
