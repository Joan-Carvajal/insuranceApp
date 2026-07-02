import sys
import pikepdf

def merge(files, output):
    pdf = pikepdf.Pdf.new()
    for f in files:
        src = pikepdf.open(f)
        pdf.pages.extend(src.pages)
        src.close()
    pdf.save(output)

if __name__ == "__main__":
    *input_files, output_file = sys.argv[1:]
    merge(input_files, output_file)
