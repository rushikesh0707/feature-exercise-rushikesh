<?php

class Supermarket_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', 'supermarket/index');
		$this->assertStringContainsString('<title>Welcome to supermarket checkout</title>', $output);
	}	
}
