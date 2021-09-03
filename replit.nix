{ pkgs }: {
	deps = [
    pkgs.php80
    pkgs.php80Extensions.curl
    pkgs.php80Extensions.mbstring
    pkgs.php80Extensions.pdo
    pkgs.php80Extensions.mysqli
    pkgs.php80Packages.composer
	];
}
