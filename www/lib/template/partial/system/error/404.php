<?

/** Special page for page not found error
 * @package errors
 */

echo $renderer->heading(l('core_page_not_found'));
Tag::p(array("class" => 'desc', "content" => l('core_page_not_found_text')));
