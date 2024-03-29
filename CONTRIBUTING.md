**Looking for help?** OpenCAD has a vast, active community of fellow users that may be able to provide assistance. Just [start a discussion](https://github.com/opencad-community/opencad/discussions/new) right here on GitHub! Or if you'd prefer to chat, join us live in the `#general-dev` channel on the [OpenCAD Community Discord](http://discord.io/opencadproject)!

<div align="center">
  <h3>
    :bug: <a href="#bug-reporting-bugs">Report a bug</a> &middot;
    :bulb: <a href="#bulb-feature-requests">Suggest a feature</a> &middot;
    :arrow_heading_up: <a href="#arrow_heading_up-submitting-pull-requests">Submit a pull request</a>
  </h3>
  <h3>
    :rescue_worker_helmet: <a href="#rescue_worker_helmet-become-a-maintainer">Become a maintainer</a> &middot;
    :heart: <a href="#heart-other-ways-to-contribute">Other ideas</a>
  </h3>
</div>
<h3></h3>

Some general tips for engaging here on GitHub:

* Register for a free [GitHub account](https://github.com/signup) if you haven't already.
* You can use [GitHub Markdown](https://docs.github.com/en/get-started/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax) for formatting text and adding images.
* To help mitigate notification spam, please avoid "bumping" issues with no activity. (To vote an issue up or down, use a :thumbsup: or :thumbsdown: reaction.)
* Please avoid pinging members with `@` unless they've previously expressed interest or involvement with that particular issue.

## :bug: Reporting Bugs

* First, ensure that you're running the [latest stable version](https://github.com/opencad-community/opencad/releases) of OpenCAD. If you're running an older version, it's likely that the bug has already been fixed.

* Next, search our [issues list](https://github.com/opencad-community/opencad/issues?q=is%3Aissue) to see if the bug you've found has already been reported. If you come across a bug report that seems to match, please click "add a reaction" in the top right corner of the issue and add a thumbs up (:thumbsup:). This will help draw more attention to it. Any comments you can add to provide additional information or context would also be much appreciated.

* If you can't find any existing issues (open or closed) that seem to match yours, you're welcome to [submit a new bug report](https://github.com/opencad-community/opencad/issues/new?label=type%3A+bug&template=bug_report.yaml). Be sure to complete the entire report template, including detailed steps that someone triaging your issue can follow to confirm the reported behavior. (If we're not able to replicate the bug based on the information provided, we'll ask for additional detail.)

* Some other tips to keep in mind:
  * Error messages and screenshots are especially helpful.
  * Don't prepend your issue title with a label like `[Bug]`; the proper label will be assigned automatically.
  * Ensure that your reproduction instructions don't reference data in our [demo instance](https://demo.opencad.io/), which gets rebuilt nightly.
  * Verify that you have GitHub notifications enabled and are subscribed to your issue after submitting.
  * We appreciate your patience as bugs are prioritized by their severity, impact, and difficulty to resolve.

* For more information on how bug reports are handled, please see our [issue
intake policy](https://github.com/opencad-community/opencad/wiki/Issue-Intake-Policy).

## :bulb: Feature Requests

* First, check the GitHub [issues list](https://github.com/opencad-community/opencad/issues?q=is%3Aissue) to see if the feature you have in mind has already been proposed. If you happen to find an open feature request that matches your idea, click "add a reaction" in the top right corner of the issue and add a thumbs up (:thumbsup:). This ensures that the issue has a better chance of receiving attention. Also feel free to add a comment with any additional justification for the feature.

* If you have a rough idea that's not quite ready for formal submission yet, start a [GitHub discussion](https://github.com/opencad-community/opencad/discussions) instead. This is a great way to test the viability and narrow down the scope of a new feature prior to submitting a formal proposal, and can serve to generate interest in your idea from other community members.

* Once you're ready, submit a feature request [using this template](https://github.com/opencad-community/opencad/issues/new?label=type%3A+feature&template=feature_request.yaml). Be sure to provide sufficient context and detail to convey exactly what you're proposing and why. The stronger your use case, the better chance your proposal has of being accepted.

* Some other tips to keep in mind:
  * Don't prepend your issue title with a label like `[Feature]`; the proper label will be assigned automatically.
  * Try to anticipate any likely questions about your proposal and provide that information proactively.
  * Verify that you have GitHub notifications enabled and are subscribed to your issue after submitting.
  * You're welcome to volunteer to implement your FR, but don't submit a pull request until it has been approved.

* For more information on how feature requests are handled, please see our [issue intake policy](https://github.com/opencad-community/opencad/wiki/Issue-Intake-Policy).

## :arrow_heading_up: Submitting Pull Requests

* [Pull requests](https://docs.github.com/en/pull-requests) (a feature of GitHub) are used to propose changes to OpenCAD's code base. Our process generally goes like this:
  * A user opens a new issue (bug report or feature request)
  * A maintainer triages the issue and may mark it as needing an owner
  * The issue's author can volunteer to own it, or someone else can
  * A maintainer assigns the issue to whomever volunteers
  * The issue owner submits a pull request that will resolve the issue
  * A maintainer reviews and merges the pull request, closing the issue

* It's very important that you not submit a pull request until a relevant issue has been opened **and** assigned to you. Otherwise, you risk wasting time on work that may ultimately not be needed.

* New pull requests should generally be based off of the `develop` branch, rather than `master`. The `develop` branch is used for ongoing development, while `master` is used for tracking stable releases. (If you're developing for an upcoming minor release, use `feature` instead.)

* In most cases, it is not necessary to add a changelog entry: A maintainer will take care of this when the PR is merged. (This helps avoid merge conflicts resulting from multiple PRs being submitted simultaneously.)

* Some other tips to keep in mind:
  * If you'd like to volunteer for someone else's issue, please post a comment on that issue letting us know. (This will allow the maintainers to assign it to you.)
  * Check out our [developer docs](https://docs.opencad.io/en/latest/#contributing) for tips on setting up your development environment.
  * All new functionality must include relevant tests where applicable.

## :heart: Other Ways to Contribute

You don't have to be a developer to contribute to OpenCAD: There are plenty of other ways you can add value to the community! Below are just a few examples:

* Help answer questions and provide feedback in our [GitHub discussions](https://github.com/opencad-community/opencad/discussions) and on [Discord](http://discord.io/opencadproject).
* Write a blog article or record a YouTube video demonstrating how OpenCAD is used in your community.