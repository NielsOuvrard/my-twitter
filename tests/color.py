from enum import Enum

class TextColor(Enum):
    RESET = "\033[0m"
    BLACK = "\033[30m"
    RED = "\033[31m"
    GREEN = "\033[32m"
    YELLOW = "\033[33m"
    BLUE = "\033[34m"
    MAGENTA = "\033[35m"
    CYAN = "\033[36m"
    WHITE = "\033[37m"
    BOLD = "\033[1m"
    UNDERLINE = "\033[4m"

    @classmethod
    def colorize(cls, text, color):
        return f"{color.value}{text}{cls.RESET.value}"

# Example usage
if __name__ == "__main__":
    print(TextColor.colorize("Hello, World!", TextColor.RED))
    print(TextColor.colorize("This is a bold text.", TextColor.BOLD))
    print(TextColor.colorize("Underlined text.", TextColor.UNDERLINE))
    print(TextColor.colorize("Green text.", TextColor.GREEN))
