<?php

class Supermarket_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', 'supermarket/index');
		$this->assertStringContainsString('<title>Welcome to supermarket checkout</title>', $output);
	}
    
    public function test_autocomplete(){
        $output = $this->request('GET', 'supermarket/get_autocomplete?term=A');
		$this->assertStringContainsString('A', $output);
    }
}
