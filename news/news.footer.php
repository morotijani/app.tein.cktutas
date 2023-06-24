    </main>

    <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
        <p>Members registration and news feed built for <a href="https://getbootstrap.com/">TEIN - CKTUTAS</a> by <a href="https://twitter.com/mdo">@IT_COMMITTEE</a>.</p>
        <p class="mb-0">
            <a href="#">Back to top</a>
        </p>
    </footer>

    <!-- SUBSCRIBE MODAL -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="subscribeModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?= PROOT; ?>news/subscriber">
                    <div class="modal-body">
                        <p class="card-text">Subscribe to our news letter for daily update of news.</p>
                            <div class="form-floating mb-2">
                                <input type="email" id="subscriber_email" name="subscriber_email" autocomplete="nope" class="form-control" placeholder="Email">
                                <label>Email</label>
                                <div class="form-text">Your data or information are saved with us. It never be shared to any third party.</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="<?= PROOT; ?>news/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
</body>
</html>
