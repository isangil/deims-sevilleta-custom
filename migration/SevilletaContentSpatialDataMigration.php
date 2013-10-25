<?php

/**
* @file
* Definition of SevilletaContentSpatialDataMigration.
*/

class SevilletaContentSpatialDataMigration extends DrupalNode6Migration {

  protected $dependencies = array();

  public function __construct(array $arguments) {
    $arguments += array(
      'description' => '',
      'source_connection' => 'drupal6',
      'source_version' => 6,
      'source_type' => 'spatial_data',
      'destination_type' => 'spatial_data',
      'user_migration' => 'DeimsUser',
    );

    parent::__construct($arguments);

    $this->addFieldMapping('field_spatialdata_kml_file', 'field_spatialdata_kml')
      ->sourceMigration('DeimsFile')
      ->arguments(array(
          'file_class' => 'MigrateFileFid',
          'preserve_files' => TRUE,
      ));

    $this->addFieldMapping('field_spatialdata_metadata_file', 'field_spatialdata_metadata')
      ->sourceMigration('DeimsFile')
      ->arguments(array(
          'file_class' => 'MigrateFileFid',
          'preserve_files' => TRUE,
      ));


    $this->addFieldMapping('field_spatialdata_shapefile_file', 'field_spatialdata_shapefile')
      ->sourceMigration('DeimsFile')
      ->arguments(array(
          'file_class' => 'MigrateFileFid',
          'preserve_files' => TRUE,
      ));


    $this->addFieldMapping('field_spatialdata_keywords', '11')
       ->sourceMigration('SevilletaTaxonomySpatialData');
      $this->addFieldMapping('field_spatialdata_keywords:source_type')  
            ->defaultValue('tid');
  }

  public function prepareRow($row) {
    parent::prepareRow($row);
  }

  public function prepare($node, $row) {
    // Remove any empty or illegal delta field values.
    EntityHelper::removeInvalidFieldDeltas('node', $node);
    EntityHelper::removeEmptyFieldValues('node', $node);
  }
   
}
