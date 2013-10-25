<?php

/**
 * @file
 * Migrate module integration for the Sevilleta module.
 */

/**
 * Implements hook_migrate_api().
 */
function sevilleta_migrate_api() {
  $info = array(
    'api' => 2,
    'migrations' => array(
      'SevilletaContentImageGallery' => array(
        'class_name' => 'SevilletaContentImageGalleryMigration',
      ),
      'SevilletaContentMetCentral' => array(
        'class_name' => 'SevilletaContentMetCentralMigration',
      ),
      /*
        Sev D6 info on vocabularies
         relation         identities
       vid  type           vid  name
        1,9 DST              1  core areas
        2   DOWNLD           2  downloads
        3   FAQ              3  articles
        5   gallery          4  sevilleta keywords (not related to any content)
       10   image            5  categories
        3   metcentral      10 image galleries
       1,9  reserch project  9 lter controlled vocab.
        1   research site   11 Spatial Data
        5   SCI image
       11   spatial_data
        3   story
      */

      'SevilletaTaxonomyCategories' => array(
        'class_name' => 'DrupalTerm6Migration',
        'description' => "Taxonomy migration for the 'Categories' vocabulary.",
        'source_connection' => 'drupal6',
        'source_version' => 6,
        // @todo Make this vocabulary source ID automatic from the D6 database.
        'source_vocabulary' => '5',
        'destination_vocabulary' => 'categories',
      ),

      'SevilletaTaxonomySpatialData' => array(
         'class_name' => 'DrupalTerm6Migration',
         'description' => "Taxonomy migration for the 'Spatial Data' vocabulary.",
         'source_connection' => 'drupal6',
         'source_version' => 6,
      // @todo Make this vocabulary source ID automatic from the D6 database.
         'source_vocabulary' => '11',
         'destination_vocabulary' => 'spatial_data',
       ),
     
    ),
  );

  foreach ($info['migrations'] as &$migration) {
    $migration['group_name'] = DEIMS_D6_MIGRATION_GROUP;
  }

  return $info;
}

/**
 * Implements hook_deims_migration_overrides().
 */
function sevilleta_deims_migration_overrides() {
  return array(
    'DeimsContentDataSet' => array('class_name' => 'SevilletaContentDataSetMigration'),
    'DeimsContentOrganization' => array('class_name' => 'SevilletaContentOrganizationMigration'),
    'DeimsContentPerson' => array('class_name' => 'SevilletaContentPersonMigration'),
    'DeimsFile' => array('class_name' => 'SevilletaFileMigration'),
  );
}
