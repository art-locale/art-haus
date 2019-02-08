<phpunit>
	<testsuites>
		<testsuite name="Art Haus Unit Testing">
      <file>applaudTest.php</file>
			<file>galleryTest.php</file>
      <file>imageTest.php</file>
      <file>profileTest.php</file>
		</testsuite>
	</testsuites>
	<filter>
		<whitelist processUncoveredFilesFromWhitelist="true">
			<directory suffix=".php">..</directory>
		</whitelist>
	</filter>
</phpunit>
