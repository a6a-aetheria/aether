<?php

namespace spec\A6A\Aether;

use A6A\Aether\Aether;
use PhpSpec\ObjectBehavior;

class AetherSpec extends ObjectBehavior
{
	function let()
	{
		$this->beAnInstanceOf('spec\A6A\Aether\AetherUser');
	}

	function it_does_get_set_has_and_unset()
	{
		// Foo can be any UpperCamelCase string
		$this->getFoo()->shouldBe(null);
		$this->hasFoo()->shouldBe(false);
		$this->setFoo(2);
		$this->hasFoo()->shouldBe(true);
		$this->getFoo()->shouldBe(2);
		$this->unsetFoo();
		$this->hasFoo()->shouldBe(false);
		$this->getFoo()->shouldBe(null);

		// shorthand unset variant
		$this->setFoo('mixed data');
		$this->getFoo()->shouldBe('mixed data');
		$this->unsFoo();
		$this->hasFoo()->shouldBe(false);
		$this->getFoo()->shouldBe(null);
	}

	function it_does_is()
	{
		// Foo can be any UpperCamelCase string
		$this->isFoo()->shouldBe(false);
		$this->isFoo(true);
		$this->isFoo()->shouldBe(true);
	}

	function it_does_merge()
	{
		// Foo can be any UpperCamelCase string
		$this->mergeFoo(1);
		$this->getFoo()->shouldBe(array(1));
		$this->mergeFoo(2);
		$this->getFoo()->shouldBe(array(1, 2));
		$this->mergeFoo(array('apple'));
		$this->getFoo()->shouldBe(array(1, 2, array('apple')));
	}

	function it_makes_undeclared_properties_work_anyway_with_getters_and_setters_etc()
	{
		$random_string = gen_random_string(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') . gen_random_string();
		$getter    = "get$random_string";
		$haser     = "has$random_string";
		$setter    = "set$random_string";
		$unsetter1 = "uns$random_string";
		$unsetter2 = "unset$random_string";

		$this->$getter()->shouldBe(null);

		$this->$haser()->shouldBe(false);

		$this->$setter('mixed data');
		$this->$getter()->shouldBe('mixed data');

		$this->$unsetter1();
		$this->$haser()->shouldBe(false);
		$this->$getter()->shouldBe(null);

		$this->$setter(array('mixed' => 'data'));
		$this->$unsetter2();
		$this->$getter()->shouldBe(null);
	}

	function it_supports_is_prefix_for_flags()
	{
		$random_string = gen_random_string(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') . gen_random_string();
		$flag = "is$random_string";

		$this->$flag()->shouldBe(false);
		$this->$flag(true);
		$this->$flag()->shouldBe(true);

		$this->$flag('');
		$this->$flag()->shouldBe(false);

		$this->$flag(44);
		$this->$flag()->shouldBe(true);

		$this->$flag(0);
		$this->$flag()->shouldBe(false);
	}

	function it_keeps_flags_separately_from_set_vars()
	{
		$random_string = gen_random_string(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') . gen_random_string();
		$getter   = "get$random_string";
		$haser    = "has$random_string";
		$setter   = "set$random_string";
		$unsetter = "uns$random_string";
		$flag     = "is$random_string";

		$this->$setter(true);
		$this->$flag()->shouldBe(false);
		$this->$getter()->shouldBe(true);
		$this->$setter('cashew rope');
		$this->$flag(true);
		$this->$getter()->shouldBe('cashew rope');
		$this->$flag()->shouldBe(true);
		$this->$unsetter();
		$this->$flag()->shouldBe(true);
	}

	function it_has_a_merge_prefix_for_pushing_to_an_array()
	{
		$random_string = gen_random_string(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') . gen_random_string();
		$getter = "get$random_string";
		$merger = "merge$random_string";
		$this->$merger('item 1');
		$this->$getter()->shouldBe(array('item 1'));
		$this->$merger('item 2');
		$this->$getter()->shouldBe(array('item 1', 'item 2'));
	}

	function it_returns_all_simulated_properties_with_a_get_method()
	{
		$this->setOne(1);
		$this->setTwo(2);
		$this->setThree(3);
		$this->get()->shouldBe(array('one' => 1, 'two' => 2, 'three' => 3));
	}

	function it_returns_all_simulated_flags_with_an_is_method()
	{
		$this->isApple(true);
		$this->isFruit(true);
		$this->isTasty(true);
		$this->is()->shouldBe(array('apple' => true, 'fruit' => true, 'tasty' => true));
	}

	function it_unsets_all_simulated_properties_with_an_unset_method()
	{
		$this->setOne(1);
		$this->setTwo(2);
		$this->setThree(3);
		$this->unset();
		$this->get()->shouldBe(array());

		// shorthand unset variant
		$this->setOne(1);
		$this->setTwo(2);
		$this->setThree(3);
		$this->uns();
		$this->get()->shouldBe(array());
	}

	function it_converts_data_to_an_array_when_merging_after_setting()
	{
		$this->setFoo(17);
		$this->mergeFoo(18);
		$this->getFoo()->shouldBe(array(17, 18));
	}

	function it_returns_the_whole_data_when_merging_something_new()
	{
		$this->setFoo(17);
		$this->mergeFoo(18)->shouldBe(array(17, 18));
	}

	function it_returns_itself_when_setting_to_allow_method_chaining()
	{
		$this->setFoo(null)->shouldHaveType('\spec\A6A\Aether\AetherUser');
		$this->uns();

		$this->setOne(1)->setTwo(2);

		// alternate style
		$this->setThree(3)
		     ->setFour(4);

		$this->get()->shouldBe(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4));
	}

	function it_returns_itself_when_unsetting_to_allow_method_chaining()
	{
		$this->unsFoo(null)->shouldHaveType('\spec\A6A\Aether\AetherUser');

		$this->setA('a')->setB('b')->setC('c');

		$this->unsA()->unsB();

		$this->get()->shouldBe(array('c' => 'c'));
	}

	function it_tracks_all_set_properties_even_if_null_until_unset()
	{
		$this->setFoo(null);
		$this->get()->shouldBe(array('foo' => null));
		$this->getFoo()->shouldBe(null);
		$this->unsFoo();
		$this->get()->shouldBe(array());
		$this->getFoo()->shouldBe(null);
	}
}

class AetherUser
{
	use \A6A\Aether\Aether;
}

function gen_random_string(
	$length = 25,
	$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
){
	$length = strlen($charset);
	$rand = '';

	for($i = 0; $i < $length; $i++){
		$rand .= $charset[rand(0, $length - 1)];
	}

	return $rand;
}