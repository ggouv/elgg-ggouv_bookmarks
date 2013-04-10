<?php
/**
 * Bookmarks English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'bookmarks' => "Bookmarks",
	'bookmarks:add' => "Add bookmark",
	'bookmarks:edit' => "Edit bookmark",
	'bookmarks:owner' => "%s's bookmarks",
	'bookmarks:friends' => "Friends' bookmarks",
	'bookmarks:everyone' => "All site bookmarks",
	'bookmarks:this' => "Bookmark this page",
	'bookmarks:this:group' => "Bookmark in %s",
	'bookmarks:inbox' => "Bookmarks inbox",
	'bookmarks:morebookmarks' => "More bookmarks",
	'bookmarks:more' => "More",
	'bookmarks:with' => "Share with",
	'bookmarks:new' => "A new bookmark",
	'bookmarks:address' => "Address of the bookmark",
	'bookmarks:none' => 'No bookmarks',

	'bookmarks:notification' =>
'%s added a new bookmark:

%s - %s
%s

View and comment on the new bookmark:
%s
',

	'bookmarks:delete:confirm' => "Are you sure you want to delete this resource?",

	'bookmarks:numbertodisplay' => 'Number of bookmarks to display',

	'bookmarks:shared' => "Bookmarked",
	'bookmarks:visit' => "Visit resource",
	'bookmarks:recent' => "Recent bookmarks",

	'river:create:object:bookmarks' => '%s bookmarked %s',
	'river:comment:object:bookmarks' => '%s commented on a bookmark %s',
	'bookmarks:river:annotate' => 'a comment on this bookmark',
	'bookmarks:river:item' => 'an item',

	'item:object:bookmarks' => 'Bookmarks',

	'bookmarks:group' => 'Group bookmarks',
	'bookmarks:enablebookmarks' => 'Enable group bookmarks',
	'bookmarks:nogroup' => 'This group does not have any bookmarks yet',
	'bookmarks:more' => 'More bookmarks',

	'bookmarks:no_title' => 'No title',

	/**
	 * Widget and bookmarklet
	 */
	'bookmarks:widget:description' => "Display your latest bookmarks.",

	/**
	 * Status messages
	 */

	'bookmarks:save:success' => "Your item was successfully bookmarked.",
	'bookmarks:delete:success' => "Your bookmark was deleted.",

	/**
	 * Error messages
	 */

	'bookmarks:save:failed' => "Your bookmark could not be saved. Make sure you've entered a title and address and then try again.",
	'bookmarks:save:invalid' => "The address of the bookmark is invalid and could not be saved.",
	'bookmarks:delete:failed' => "Your bookmark could not be deleted. Please try again.",
);

add_translation('en', $english);