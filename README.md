The main driving force behind using a facade was that fact that seems like a fairly useful piece of logic that other teams within Street Group might want to use, so it has been made with no particular ties to any class. 
However, utilising collection this would be fairly easy to map these people into models.

I have purposely not flattened the people array because the use case for this (in my opinion) is that people that own a home together can now sit in their own array. 
This means that can be more easily associated with another model (i.e. House/Sale etc).
If this is not the intended purpose then it would be easy enough to flatten this down.

Storing the CSV means we can process this in a job. 
The decision for this was driven by the fact there is a potential that onboarding a new client they could have quite a large back catalogue of people, meaning these CSVs could be quite large, and we wouldn't want the client to be sat around waiting for a large file to process.
It also frees up the ability to utilise a more long-running job and there are less susceptible to a time-out

If there was a planning phase for this as a CR then I would have raised that we'd probably want to validate each row and send a summary email back to the user saying who has and hasn't been inserted into the database.
This logic would be quite easy to add in, in its current implementation, meaning little time needed for refactoring.

I'd normally spend time setting up and configuring Laravel Pint, PHP Stan, eslint and prettier but given the time constraint on the test I skipped this step.
