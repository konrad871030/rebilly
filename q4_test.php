<?php
require_once __DIR__ . '/q4.php';

$GLOBALS['_q4_tests_passed'] = 0;
$GLOBALS['_q4_tests_failed'] = 0;

function q4_assert(bool $condition, string $message): void
{
    if ($condition) {
        $GLOBALS['_q4_tests_passed']++;
        return;
    }
    $GLOBALS['_q4_tests_failed']++;
    fwrite(STDERR, "FAIL: {$message}\n");
}

function q4_assertSame($expected, $actual, string $message): void
{
    if ($expected === $actual) {
        $GLOBALS['_q4_tests_passed']++;
        return;
    }
    $GLOBALS['_q4_tests_failed']++;
    $exp = var_export($expected, true);
    $act = var_export($actual, true);
    fwrite(STDERR, "FAIL: {$message}\n  oczekiwano: {$exp}\n  otrzymano: {$act}\n");
}

function q4_assertThrowsInvalidArgument(callable $fn, string $message): void
{
    try {
        $fn();
        $GLOBALS['_q4_tests_failed']++;
        fwrite(STDERR, "FAIL: {$message} — InvalidArgumentException was not thrown\n");
    } catch (InvalidArgumentException $e) {
        $GLOBALS['_q4_tests_passed']++;
    } catch (Throwable $e) {
        $GLOBALS['_q4_tests_failed']++;
        fwrite(STDERR, "FAIL: {$message} — caught " . get_class($e) . " instead of InvalidArgumentException\n");
    }
}

// Range 1–15: full FizzBuzz pattern
q4_assertSame(
    '12Fizz4BuzzFizz78FizzBuzz11Fizz1314FizzBuzz',
    fizzBuzz(1, 15),
    'fizzBuzz(1, 15) — classic sequence'
);

// Single numbers
q4_assertSame('1', fizzBuzz(1, 1), 'only number');
q4_assertSame('Fizz', fizzBuzz(3, 3), 'only Fizz');
q4_assertSame('Buzz', fizzBuzz(5, 5), 'only Buzz');
q4_assertSame('FizzBuzz', fizzBuzz(15, 15), 'only FizzBuzz');

// Order of conditions: 15 must be FizzBuzz, not Fizz or Buzz separately
q4_assertSame('14FizzBuzz', fizzBuzz(14, 15), '15 as FizzBuzz after 14');

// Zero is allowed; 0 is divisible by 3 and 5 → FizzBuzz
q4_assertSame('FizzBuzz', fizzBuzz(0, 0), 'range [0,0] → FizzBuzz');

// Range with zero and numbers
q4_assertSame('FizzBuzz12Fizz4Buzz', fizzBuzz(0, 5), 'from 0 to 5');

// Invalid arguments
q4_assertThrowsInvalidArgument(
    static function () {
        fizzBuzz(10, 5);
    },
    'stop < start' 
);

q4_assertThrowsInvalidArgument(
    static function () {
        fizzBuzz(-1, 5);
    },
    'start < 0' 
);

q4_assertThrowsInvalidArgument(
    static function () {
        fizzBuzz(0, -1);
    },
    'stop < 0' 
);

q4_assertThrowsInvalidArgument(
    static function () {
        fizzBuzz(-3, -5);
    },
    'negative boundaries (both < 0)' 
);

// Default arguments 1–100: known start and end (without duplicate logic in the middle)
$full = fizzBuzz();
q4_assert(
    substr($full, 0, 43) === '12Fizz4BuzzFizz78FizzBuzz11Fizz1314FizzBuzz',
    'fizzBuzz() — start of the sequence 1–100'
);
$len = strlen($full);
q4_assert(
    $len >= 10 && substr($full, -10) === '98FizzBuzz',
    'fizzBuzz() — end of the sequence 1–100 (…98FizzBuzz)'
);

// Length of the result for 1–100 is constant (easy to verify regression)
q4_assertSame(313, strlen($full), 'fizzBuzz() — length of the string for 1–100');

// Boundary: adjacent Buzz / Fizz
q4_assertSame('4BuzzFizz', fizzBuzz(4, 6), '4, Buzz, Fizz');

// --- Summary ---
$failed = $GLOBALS['_q4_tests_failed'];
$passed = $GLOBALS['_q4_tests_passed'];

if ($failed > 0) {
    fwrite(STDERR, "\nResult: {$passed} OK, {$failed} errors\n");
    exit(1);
}

echo "All tests passed: {$passed}.\n";
exit(0);
