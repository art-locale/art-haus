<phpunit>
	<testsuites>
		<testsuite name="ArtHausTest">
      <file>TestApplaud.php</file>
			<file>TestGallery.php</file>
      <file>TestImage.php</file>
      <file>TestProfile.php</file>
		</testsuite>
	</testsuites>
	<filter>
		<whitelist processUncoveredFilesFromWhitelist="true">
			<directory suffix=".php">..</directory>
		</whitelist>
	</filter>
</phpunit>
