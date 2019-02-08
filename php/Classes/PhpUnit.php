<phpunit>
	<testsuites>
		<testsuite name="ArtHausTest">
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
