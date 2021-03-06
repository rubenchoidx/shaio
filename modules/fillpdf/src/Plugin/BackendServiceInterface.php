<?php

namespace Drupal\fillpdf\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for FillPDF BackendService plugins.
 *
 * NOTE: Plugin IDs for BackendService plugins should match the ones used for
 * FillPdfBackend plugins.
 *
 * Also, FillPdfBackend plugins should ideally simply
 * call out to BackendService plugins.
 *
 * I am probably going to deprecate FillPdfBackend plugins once I have time to
 * convert the code using them.
 */
interface BackendServiceInterface extends PluginInspectionInterface {

  /**
   * Parse a PDF and return a list of its fields.
   *
   * @param string $pdf
   *   The PDF whose fields are going to be parsed. This should be the contents
   *   of a PDF loaded with something like file_get_contents() or equivalent.
   * @return array An array of arrays containing metadata about
   *   the fields in the PDF. These can be iterated over and saved by the
   *   caller.
   */
  public function parse($pdf);

  /**
   * Accept an array of PDF field keys and FieldMapping objects
   * and populate the PDF using them.
   *
   * @param string $pdf The PDF into which to merge the field values specified
   *   in the mapping.
   * @param array $field_mappings \Drupal\fillpdf\FieldMapping[]
   *   An array of FieldMapping-derived objects mapping PDF field keys to the
   *   values with which they should be replaced. Strings are also acceptable
   *   and converted to TextFieldMapping objects.
   *
   *   Example array:
   *
   * @code
   * [
   *   'Foo' => new TextFieldMapping('bar'),
   *   'Foo2' => new TextFieldMapping('bar2'),
   *   'Image1' => new ImageFieldMapping(base64_encode(file_get_contents($image)), 'jpg'),
   * ]
   * @endcode
   * @param array $options
   *   Additional options, usually relating to plugin-specific functionality.
   * @return string The raw file contents of the new PDF; the caller has to
   *   handle saving or serving the file accordingly.
   *
   * @see \Drupal\fillpdf\FieldMapping
   * @see \Drupal\fillpdf\FieldMapping\TextFieldMapping
   * @see \Drupal\fillpdf\FieldMapping\ImageFieldMapping
   */
  public function merge($pdf, array $field_mappings, array $options);

}
