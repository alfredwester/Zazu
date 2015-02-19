			<hr>
            <footer class="span-24 footer">
                <pre><?=$regions['footer']['region_text'];?></pre>
            </footer>
        </div>
        <?php 
		if(isset($footer_js)) {
			echo "<!-- javascripts from dynamic places  -->\n";
			foreach ($footer_js as $js) {
				echo "\t\t<script type=\"text/javascript\" src=\"".BASE_PATH."/".$js."\"></script>\n";
			}
		}
		?>
    </body>
</html>
