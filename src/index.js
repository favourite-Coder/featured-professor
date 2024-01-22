import "./index.scss";
import {useSelect} from "@wordpress/data";
import {useState, useEffect} from "react";
import apiFetch from "@wordpress/api-fetch";


wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    profId: {type: "string"}
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const [thePreview, setThePreview] = useState("")

  useEffect(() => {
    async function go() {
      const response = await apiFetch({
        path: `/featuredProfessor/v1/getHTML?profId=${props.attributes.profId}`,
        method: "GET"
      })
      setThePreview(response)
    }
    go()
  }, [props.attributes.profId])
  
  const allProfs = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", {per_page: -1})
  })

  console.log(allProfs)

  if (allProfs == undefined) return <p>Loading...</p>

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({profId: e.target.value})}>
          <option value="">Select a professor</option>
          {allProfs.map(prof => {
            return (
              <option value={prof.id} selected={props.attributes.profId == prof.id}>
                {prof.title.rendered}
              </option>
            )
          })}
        </select>
      </div>
      <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
    </div>
  )
}