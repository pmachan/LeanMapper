<?php

use LeanMapper\Result;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

//////////

/**
 * @property DateTime $published
 */
class Book extends LeanMapper\Entity
{
}

//////////

$book = new Book;

$book->published = new DibiDateTime;

Assert::type('DibiDateTime', $book->published);

Assert::exception(function () use ($book) {
	$book->published = new ArrayObject;
}, 'LeanMapper\Exception\InvalidValueException', "Unexpected value type given in property 'published' in entity Book, DateTime expected, instance of ArrayObject given.");

//////////

$dibiRow = new DibiRow(array(
	'published' => new ArrayObject
));

$book = new Book(Result::createInstance($dibiRow, 'book', $connection, $mapper)->getRow(Result::DETACHED_ROW_ID));

Assert::exception(function () use ($book) {
	$book->published;
}, 'LeanMapper\Exception\InvalidValueException', "Property 'published' in entity Book is expected to contain an instance of DateTime, instance of ArrayObject given.");

//////////

$dibiRow = new DibiRow(array(
	'published' => new DibiDateTime
));

$book = new Book(Result::createInstance($dibiRow, 'book', $connection, $mapper)->getRow(Result::DETACHED_ROW_ID));

Assert::type('DibiDateTime', $book->published);
Assert::type('DateTime', $book->published);