<?php
/**
 * ShortUrlTest
 * @group model
 */
class ShortUrlTest extends PHPUnit_Framework_TestCase
{
		/**
		 * @test
		 */
	function testFieldTypeCast() {

				$s = new ShortUrl();

				$s->short_url = 123;
				$this->assertSame('123', $s->short_url);

				$s->long_url = 123;
				$this->assertSame('123', $s->long_url);

				$s->title = 123;
				$this->assertSame('123', $s->title);

				$s->end_url = 123;
				$this->assertSame('123', $s->end_url);

				$s->created = '2014-01-01';
				$this->assertInstanceOf('DateTime', $s->created);

				$s->end_date = '2014-01-01';
				$this->assertInstanceOf('DateTime', $s->end_date);
		}

		/**
		 * @test
		 */
		function testIsValid() {
				$s = new ShortUrl;
				$s->short_url = str_pad('', 200, 'a');
				$s->long_url = str_pad('', 200, 'b');
				$s->title = str_pad('', 200, 'b');
				$s->end_url = str_pad('', 200, 'b');
		}
}
