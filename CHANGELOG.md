Unreleased
==========

BC Break:

- Templating: `{{ foo.bar }}` is now treated as an object/array access, as per
  Twig.

Features:

- Use Twig instead of token replacement.
- `post_install` tasks, allows running arbitrary commands after install /
  generation.

