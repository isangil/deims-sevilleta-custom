<?php

/**
 * @file
 * Definition of SevilletaContentImageGalleryMigration.
 */

class SevilletaContentImageGalleryMigration extends DrupalNode6Migration {
  protected $sourceFields = array(
    'field_images' => 'Images - provided in prepare()',
  );

  protected $dependencies = array('DeimsFile');

  public function __construct(array $arguments) {
    $arguments += array(
      'description' => '',
      'source_connection' => 'drupal6',
      'source_version' => 6,
      'source_type' => 'gallery',
      'destination_type' => 'image_gallery',
      'user_migration' => 'DeimsUser',
    );

    parent::__construct($arguments);

    $this->addFieldMapping('field_images', 'field_images')
      ->sourceMigration(array('DeimsFile'))
      ->arguments(array(
        'file_class' => 'MigrateFileFid',
        'preserve_files' => TRUE,
      ))
      ->description('Handled in prepareRow().');

    $this->addUnmigratedSources(array(
      'field_image_gallery_highlight',
      'field_image_gallery_highlight:list',
      'field_image_gallery_highlight_data',
      '5', // Categories vocabulary.
    ));

    $this->addUnmigratedDestinations(array(
      'field_images:file_class',
      'field_images:language',
      'field_images:destination_dir',
      'field_images:destination_file',
      'field_images:file_replace',
      'field_images:preserve_files',
      'field_images:source_dir',
      'field_images:urlencode',
      'field_images:alt',
      'field_images:title',
      'field_keywords',
      'field_keywords:source_type',
      'field_keywords:create_term',
      'field_keywords:ignore_case',
    ));
  }

  public function prepareRow($row) {
    parent::prepareRow($row);

    // Find all the scientific images that are attached to this gallery node.
    $connection = Database::getConnection('default', $this->sourceConnection);
    $query = $connection->select('node', 'n');
    $query->join('node_revisions', 'nr', 'n.vid = nr.vid');
    $query->condition('n.type', 'scientific_image');
    $query->join('content_type_scientific_image', 'ctsi', 'n.vid = ctsi.vid');
    $query->condition('ctsi.field_scientific_image_gallery_nid', $row->nid);
    $query->fields('ctsi', array('field_sci_image_fid'));
    $row->field_images = $query->execute()->fetchCol();
  }

  public function prepare($node, $row) {
    // Remove any empty or illegal delta field values.
    EntityHelper::removeInvalidFieldDeltas('node', $node);
    EntityHelper::removeEmptyFieldValues('node', $node);
  }
}
