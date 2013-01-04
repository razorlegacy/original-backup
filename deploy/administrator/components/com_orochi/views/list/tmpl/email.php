<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	//print_r($this->originObj->id);
	//print_r($this->emailObj);
	//print_r(JFactory::getUser());
	
	$config		=& JFactory::getConfig();
	$user		=& JFactory::getUser();
	$mailer		=& JFactory::getMailer();
	$syndiObj	= json_decode($this->syndiObj->content);

/*
	$auto		= (isset($this->emailObj['auto']))? $this->emailObj['auto'].' per 24 hours': 'N/A';
	$close		= (isset($this->emailObj['close']))? $this->emailObj['close'].' seconds': 'N/A';
	$hover		= (isset($this->emailObj['hover']))? $this->emailObj['hover'].' seconds': 'N/A';
	$clickthru1	= (isset($this->emailObj['clickthru1']))? '<a href="'.$this->emailObj['clickthru1'].'">'.$this->emailObj['clickthru1'].'</a>': 'N/A';
	$clickthru2	= (isset($this->emailObj['clickthru2']))? '<a href="'.$this->emailObj['clickthru2'].'">'.$this->emailObj['clickthru2'].'</a>': 'N/A';
	$clickthru3	= (isset($this->emailObj['clickthru3']))? '<a href="'.$this->emailObj['clickthru3'].'">'.$this->emailObj['clickthru3'].'</a>': 'N/A';
	$clickthru4	= (isset($this->emailObj['clickthru4']))? '<a href="'.$this->emailObj['clickthru4'].'">'.$this->emailObj['clickthru4'].'</a>': 'N/A';
	$clickthru5	= (isset($this->emailObj['clickthru5']))? '<a href="'.$this->emailObj['clickthru5'].'">'.$this->emailObj['clickthru5'].'</a>': 'N/A';
*/


	$sender		= array($config->getValue('config.mailfrom'), $config->getValue('config.fromname'));
	$recipient	= $user->email;
	$subject	= '[Origin] Project Details - '.$syndiObj->title.' [Origin Syndi ID: '.$syndiObj->id.']';
	$body		= '<p>Details for Origin Project #'.$syndiObj->id.': <strong>'.$syndiObj->title.'</strong></p>';
	$body		.= '<h3>Embed Code</h3>';
	$body		.= '<p style="font-style: italic">Use the "Evolve Origin" DFP template.</p>';
	$body		.= '<blockquote style="background-color: #ebebeb; padding: 5px;">'.htmlentities($this->emailObj['syndi_list_embed_code']).'</blockquote>';
/*
	$body		.= '<h3>Default Values</h3>';
	$body		.= '<p style="font-style: italic">Campaign Management can override these values through the DFP template.</p>';
	$body		.= '<ul>';
	$body		.= '<li>'.'Auto Open: <strong>'.$auto.'</strong></li>';
	$body		.= '<li>'.'Auto Close Unit: <strong>'.$close.'</strong></li>';
	$body		.= '<li>'.'Hover Intent: <strong>'.$hover.'</strong></li>';
	$body		.= '<li>'.'Clickthru 1: <strong>'.$clickthru1.'</strong></li>';
	$body		.= '<li>'.'Clickthru 2: <strong>'.$clickthru2.'</strong></li>';
	$body		.= '<li>'.'Clickthru 3: <strong>'.$clickthru3.'</strong></li>';
	$body		.= '<li>'.'Clickthru 4: <strong>'.$clickthru4.'</strong></li>';
	$body		.= '<li>'.'Clickthru 5: <strong>'.$clickthru5.'</strong></li>';
	$body 		.= '</ul>';
*/
	$body		.= '<h3>Preview Link</h3>';
	$body		.= '<a href="'.$this->emailObj['link'].'&type='.$this->emailObj['syndi_height'].'">'.$this->emailObj['link'].'&type='.$this->emailObj['syndi_height'].'</a>';
	
	$mailer->setSender($sender);
	$mailer->addRecipient($recipient);
	$mailer->setSubject($subject);
	$mailer->isHTML(true);
	$mailer->Encoding = 'base64';
	$mailer->setBody($body);
	$send 		=& $mailer->Send();
?>