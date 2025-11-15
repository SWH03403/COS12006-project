<?php
function html_sanitize(string $data): string {
	return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Coerce stateful string like 'yes', 'no', 'true', 'false', ... to a boolean.
function parse_bool(string $s): ?bool {
	return filter_var($s, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
}

function label_to_name(string $s): string { return strtolower(str_replace(' ', '-', $s)); }

class Range {
	public function __construct(public int $begin, public int $end) {}
	public function contains(int $x) { return $this->begin <= $x && $x <= $this->end; }
}
