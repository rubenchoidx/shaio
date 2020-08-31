<?php

namespace Drupal\fillpdf;

/**
 * Defines the required interface for all FillPDF BackendService plugins.
 *
 * @package Drupal\fillpdf
 *
 * @todo: Implement PluginInspectionInterface, ConfigurablePluginInterface and update implementations accordingly.
 */
interface FillPdfBackendPluginInterface {

  /**
   * Parse a PDF and return a list of its fields.
   *
   * @param FillPdfFormInterface $fillpdf_form The PDF whose fields
   *   are going to be parsed.
   * @return array
   *   An array of associative arrays. Each sub-array contains a 'name' key with
   *   the name of the field and a 'type' key with the type. These can be
   *   iterated over and saved by the caller.
   */
  public function parse(FillPdfFormInterface $fillpdf_form);

  /**
   * Formerly known as merging. Accept an array of PDF field keys and field
   * values and populate the PDF using them.
   *
   * @param FillPdfFormInterface $pdf_form The FillPdfForm referencing the file
   *   whose field values are going to be populated.
   * @param array $field_mapping An array of fields mapping PDF field keys to the
   *   values with which they should be replaced. Example array:
   *
   * @code
   *   array(
   *     'values' => array(
   *       'Field 1' => 'value',
   *       'Checkbox Field' => 'On',
   *     ),
   *     'images' => array(
   *       'Image Field 1' => array(
   *         'data' => base64_encode($file_data),
   *         'filenamehash' => md5($image_path_info['filename']) . '.' . $image_path_info['extension'],
   *       ),
   *     ),
   *   )
   * @endcode
   * @param array $context @todo: Define
   * @return string The raw file contents of the new PDF; the caller has to
   *   handle saving or serving the file accordingly.
   */
  public function populateWithFieldData(FillPdfFormInterface $pdf_form, array $field_mapping, array $context);
}