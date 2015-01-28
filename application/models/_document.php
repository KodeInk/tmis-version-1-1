<?php
/**
 * Handles document uploads and tracking.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _document extends CI_Model
{
	
	# STUB: Add a new document
	function add_new($documentDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
	
	
		
	# STUB: Remove a document.
	function remove($documentId)
	{
		$isRemoved = false;
		
		
		return $isRemoved;
	}
	
	
		
	# STUB: Update a document's details.
	function update($documentId)
	{
		$isUpdated = false;
		
		
		return $isUpdated;
	}
	
	
		
	# STUB: Get document details
	function get_details($documentId)
	{
		$documentDetails = array();
		
		
		return $documentDetails;
	}



	# Generate a letter with the passed details
	function generate_letter($code, $details, $action='save')
	{
		# 1. Generate the letter name
		$letterUrl = 'CONF'.strtotime('now').'.pdf';
		$location = UPLOAD_DIRECTORY.'documents/';
		
		# 2. Load the letter details from the database
		$template = $this->get_template_by_code($code);
		# 3. Generate the document from the view
		$document = $this->populate_template($template, $details);
		$this->generate_pdf($document, $location.$letterUrl, $action);
		
		# If the file is created, then return the file name, else, just an empty string
		return file_exists($location.$letterUrl)? $location.$letterUrl: '';
	}
	
	
	
	
	
	# Generate a PDF document
	function generate_pdf($document, $url, $action)
	{
		# get the external library that generates the PDF
		require_once(HOME_URL."external_libraries/dompdf/dompdf_config.inc.php");

		# Strip slashes if this PHP version supports get_magic_quotes
		$document = get_magic_quotes_gpc()? stripslashes($document): $document;
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($document);
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->render();
	
		# Store the entire PDF as a string in $pdf
		$pdf = $dompdf->output();
		# Write $pdf to disk
		file_put_contents($url, $pdf);

		# If the user wants to download the file, then stream it instead
		if($action == 'download')
		{
			$dompdf->stream($filename, array("Attachment" => true));
			exit(0);
		}
	}
	
	
	
			
	
	
	# Get a template of the document given its code
	function get_template_by_code($code)
	{
		return $this->_query_reader->get_row_as_array('get_message_template', array('message_type'=>$code));
	}	
				
	
	
	# Populate the template to generate the actual document content
	function populate_template($template, $values=array())
	{
		$document = "";
		if(!empty($template['details']))
		{
			# Order keys by length - longest first
			array_multisort(array_map('strlen', array_keys($values)), SORT_DESC, $values);
			
			# go through all passed values and replace where they appear in the template text
			foreach($values AS $key=>$value)
			{
				$template['details'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['details']);
			}
			$document = $template['details'];
		}
		
		return $document;
	}
	

}


?>