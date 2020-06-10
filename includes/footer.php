</div>

<style>
    .footer {
    position: relative;
    height: 20px;
    background-color: red;
    bottom: 0px;
    left: 0px;
    right: 0px;
    margin-bottom: 0px;
    opacity: 1; 
    background-color: rgba(0,0,0,0.6);
}

</style>

<div class="footer" style="background-color: inherit; text-align: center;">
    &copy; <?php
            $thisYear = (int) date('Y');
            echo $thisYear ?> Thomas Desrosiers
</div>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>