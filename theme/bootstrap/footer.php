			</div>
		</div>
		<footer id="footer">
			<div class="divider"></div>
			<div class="container">
				<div class="row">
					<div class="span12">
						Zazu Administration
					</div>
				</div>
			</div>
		</footer>
		<script type="text/javascript" src="<?php echo BASE_PATH;?>/include/jquery/jquery.min.js" ></script>
		<script type="text/javascript" src="<?php echo BASE_PATH;?>/include/bootstrap/js/bootstrap.min.js" ></script>
		<?php 
		if(!empty($footer_js)) {
			foreach ($footer_js as $js) {
				echo "<script type=\"text/javascript\" src=\"".BASE_PATH."/".$js."\"></script>";
			}
		}
		?>
    </body>
</html>
