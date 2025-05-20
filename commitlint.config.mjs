// ref. https://commitlint.js.org/#/reference-rules

export default {
    rules: {
        // short description, no more than 72 chars
        "header-max-length" : [2, "always", 72],

        // body should end with a dot
        "body-full-stop": [2, "always", "."],

        // body begins with blank line
        "body-leading-blank": [2, "always"],

        // body, no more than 72 chars in a line
        "body-max-line-length": [2, "always", 72],

        // body, say something, at least 15 chars
        "body-min-length": [2, "always", 15],

        // we should start with: "An upper case and continue" in the body
        "body-case": [2, "always", "sentence-case"],

        // we don't accept ending dots in the header
        "header-full-stop": [2, "never", "."],

        // header message is required, at least 15 chars
        "header-min-length": [2, "always", "15"],

        // subject should start with: "An upper case and continue"
        "subject-case": [2, "always", "sentence-case"],
    }
}
